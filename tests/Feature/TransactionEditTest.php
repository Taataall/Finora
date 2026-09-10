<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_edit_form_for_their_transaction(): void
    {
        $user = User::factory()->create();
        $transaction = $this->createTransaction($user);

        $response = $this->actingAs($user)->get(route('transactions.edit', $transaction));

        $response->assertStatus(200);
        $response->assertSee('Edit Transaksi');
        $response->assertSee('Gaji');
    }

    public function test_user_can_update_their_transaction(): void
    {
        $user = User::factory()->create();
        $transaction = $this->createTransaction($user);

        $response = $this->actingAs($user)->put(route('transactions.update', $transaction), [
            'jenis' => 'pengeluaran',
            'jumlah' => 25000,
            'kategori' => 'Makan',
            'catatan' => 'Nasi goreng',
            'tanggal' => '2026-09-03',
        ]);

        $response->assertRedirect(route('transactions.history', absolute: false));

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'user_id' => $user->id,
            'jenis' => 'pengeluaran',
            'jumlah' => 25000,
            'kategori' => 'Makan',
            'catatan' => 'Nasi goreng',
            'tanggal' => '2026-09-03',
        ]);
    }

    public function test_user_cannot_edit_another_users_transaction(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $transaction = $this->createTransaction($owner);

        $this->actingAs($otherUser)
            ->get(route('transactions.edit', $transaction))
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->put(route('transactions.update', $transaction), [
                'jenis' => 'pengeluaran',
                'jumlah' => 25000,
                'kategori' => 'Makan',
                'catatan' => 'Nasi goreng',
                'tanggal' => '2026-09-03',
            ])
            ->assertForbidden();
    }

    public function test_admin_can_edit_any_transaction(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $transaction = $this->createTransaction($owner);

        $this->actingAs($admin)
            ->get(route('transactions.edit', $transaction))
            ->assertStatus(200);
    }

    private function createTransaction(User $user): Transaction
    {
        return Transaction::create([
            'user_id' => $user->id,
            'jenis' => 'pemasukan',
            'jumlah' => 100000,
            'kategori' => 'Gaji',
            'catatan' => 'Awal bulan',
            'tanggal' => '2026-09-01',
        ]);
    }
}
