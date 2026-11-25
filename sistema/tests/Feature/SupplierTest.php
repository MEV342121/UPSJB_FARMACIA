<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    private int $userCounter = 0;

    public function test_ruc_debe_tener_once_digitos_y_muestra_el_error_en_espanol(): void
    {
        config(['app.locale' => 'es']);

        $this->actingAs($this->createUserWithRole('Administrador'))
            ->from(route('suppliers.create'))
            ->post(route('suppliers.store'), $this->supplierData(['ruc' => '1234567890']))
            ->assertSessionHasErrors([
                'ruc' => 'El campo RUC debe tener 11 dígitos.',
            ]);
    }

    public function test_no_permite_registrar_un_ruc_duplicado(): void
    {
        $this->actingAs($this->createUserWithRole('Administrador'));
        Supplier::create($this->supplierData());

        $this->post(route('suppliers.store'), $this->supplierData())
            ->assertSessionHasErrors('ruc');
    }

    public function test_editar_sin_cambiar_el_ruc_guarda_el_proveedor(): void
    {
        $supplier = Supplier::create($this->supplierData());

        $this->actingAs($this->createUserWithRole('Administrador'))
            ->put(route('suppliers.update', $supplier), $this->supplierData([
                'name' => 'Distribuidora actualizada',
            ]))
            ->assertRedirect(route('suppliers.index'));

        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'Distribuidora actualizada',
            'ruc' => '20000000001',
        ]);
    }

    public function test_administrador_y_quimico_pueden_ver_proveedores(): void
    {
        foreach (['Administrador', 'Químico farmacéutico'] as $roleName) {
            $this->actingAs($this->createUserWithRole($roleName))
                ->get(route('suppliers.index'))
                ->assertOk();

            $sidebar = view('partials.sidebar')->render();

            $this->assertStringContainsString('href="'.route('suppliers.index').'"', $sidebar);
        }
    }

    public function test_cajero_recibe_403_y_no_ve_el_enlace_del_menu(): void
    {
        $this->actingAs($this->createUserWithRole('Cajero'))
            ->get(route('suppliers.index'))
            ->assertForbidden();

        $sidebar = view('partials.sidebar')->render();

        $this->assertStringNotContainsString('Proveedores', $sidebar);
    }

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::create([
            'name' => $roleName,
            'description' => 'Rol para pruebas',
        ]);

        $this->userCounter++;

        return User::create([
            'role_id' => $role->id,
            'name' => 'Usuario de prueba',
            'dni' => str_pad((string) $this->userCounter, 8, '0', STR_PAD_LEFT),
            'phone' => '900000001',
            'email' => 'usuario'.$this->userCounter.'@example.test',
            'password' => 'password',
        ]);
    }

    private function supplierData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Distribuidora de prueba',
            'ruc' => '20000000001',
            'phone' => '900000001',
            'email' => 'contacto@proveedor.test',
            'address' => 'Av. de prueba 123',
        ], $overrides);
    }
}
