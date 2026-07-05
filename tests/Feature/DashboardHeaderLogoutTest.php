<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

function makeAuthenticatedUser(string $role): Authenticatable
{
    return new class($role) implements Authenticatable {
        public function __construct(private string $role)
        {
        }

        public string $name = 'Test User';

        public function getAuthIdentifierName(): string
        {
            return 'id';
        }

        public function getAuthIdentifier(): mixed
        {
            return 1;
        }

        public function getAuthPassword(): string
        {
            return 'password';
        }

        public function getAuthPasswordName(): string
        {
            return 'password';
        }

        public function getRememberToken(): ?string
        {
            return null;
        }

        public function setRememberToken($value): void
        {
        }

        public function getRememberTokenName(): string
        {
            return 'remember_token';
        }

        public function hasRole(string $role): bool
        {
            return $this->role === $role;
        }

        public function hasVerifiedEmail(): bool
        {
            return true;
        }
    };
}

it('shows a logout button in the mahasiswa dashboard header', function () {
    $user = makeAuthenticatedUser('mahasiswa');
    Auth::login($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Logout');
});

it('shows a logout button in the admin dashboard header', function () {
    $user = makeAuthenticatedUser('admin');
    Auth::login($user);

    $response = $this->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertSee('Logout');
});
