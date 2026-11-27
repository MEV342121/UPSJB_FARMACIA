<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_formulario_login_conserva_el_prototipo_y_no_carga_app_js(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('login-wrapper')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false)
            ->assertSee('data-login-form')
            ->assertDontSee('id="loginForm"', false)
            ->assertDontSee('js/app.js');
    }

    public function test_usuario_autenticado_es_redirigido_del_login_al_dashboard(): void
    {
        $this->actingAs($this->createUserWithRole('Administrador'))
            ->get(route('login'))
            ->assertRedirect(route('dashboard.index'));
    }

    public function test_sidebar_muestra_iniciales_nombre_correo_y_rol_del_usuario(): void
    {
        $user = $this->createUserWithRole('Administrador');
        $this->actingAs($user);

        $sidebar = view('partials.sidebar')->render();

        $this->assertStringContainsString(
            '<span class="text-white fw-bold lh-1">US</span>',
            $sidebar
        );
        $this->assertStringContainsString($user->name, $sidebar);
        $this->assertStringContainsString($user->email, $sidebar);
        $this->assertStringContainsString('Administrador', $sidebar);
    }

    public function test_usuario_autorizado_inicia_sesion_y_puede_abrir_proveedores(): void
    {
        $user = $this->createUserWithRole('Administrador');

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard.index'));

        $this->assertAuthenticatedAs($user);

        $this->get(route('suppliers.index'))
            ->assertOk()
            ->assertSee('Proveedores');
    }

    public function test_credenciales_incorrectas_muestran_error_y_conservan_solo_el_correo(): void
    {
        $user = $this->createUserWithRole('Administrador');

        $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'incorrecta',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'email' => 'El correo o la contraseña no son correctos.',
            ])
            ->assertSessionHas('_old_input.email', $user->email)
            ->assertSessionMissing('_old_input.password');
    }

    public function test_cajero_autenticado_recibe_403_en_proveedores(): void
    {
        $user = $this->createUserWithRole('Cajero');

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard.index'));

        $this->get(route('suppliers.index'))->assertForbidden();
    }

    public function test_cerrar_sesion_invalida_la_autenticacion(): void
    {
        $user = $this->createUserWithRole('Administrador');
        $this->actingAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('ok', 'Cerraste sesión correctamente.');

        $this->assertGuest();
    }

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::create([
            'name' => $roleName,
            'description' => 'Rol para pruebas',
        ]);

        return User::create([
            'role_id' => $role->id,
            'name' => 'Usuario de prueba',
            'dni' => '12345678',
            'phone' => '900000001',
            'email' => 'usuario@example.test',
            'password' => 'password',
        ]);
    }
}
