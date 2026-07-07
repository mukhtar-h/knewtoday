<?php

use App\Enums\UserRole;
use App\Models\User;

test('writers cannot access user management', function () {
    $writer = User::factory()->create([
        'role' => UserRole::Writer,
    ]);

    $this->actingAs($writer)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

test('admins can access user management', function () {
    $admin = User::factory()->create([
        'role' => UserRole::Admin,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk();
});
