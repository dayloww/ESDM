<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_admin_role_helpers(): void
    {
        $user = $this->userWithRole('Admin');

        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isOperator());
        $this->assertTrue($user->canManageData());
        $this->assertTrue($user->canDeleteData());
        $this->assertTrue($user->canManageUsers());
    }

    public function test_operator_role_helpers(): void
    {
        $user = $this->userWithRole('Operator');

        $this->assertFalse($user->isAdmin());
        $this->assertTrue($user->isOperator());
        $this->assertTrue($user->canManageData());
        $this->assertFalse($user->canDeleteData());
        $this->assertFalse($user->canManageUsers());
    }

    public function test_unknown_and_missing_roles_are_denied(): void
    {
        $unknown = $this->userWithRole('Auditor');

        $this->assertFalse($unknown->isAdmin());
        $this->assertFalse($unknown->isOperator());
        $this->assertFalse($unknown->canManageData());
        $this->assertFalse($unknown->canDeleteData());
        $this->assertFalse($unknown->canManageUsers());

        $missingRole = new User;

        $this->assertFalse($missingRole->canManageData());
        $this->assertFalse($missingRole->canDeleteData());
        $this->assertFalse($missingRole->canManageUsers());
    }

    private function userWithRole(string $roleName): User
    {
        $user = new User;
        $user->setRelation('role', new Role(['nama_role' => $roleName]));

        return $user;
    }
}
