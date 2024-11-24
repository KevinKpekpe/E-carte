<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function manage(User $user, Employee $employee)
    {
        return $user->company->id === $employee->company_id;
    }
}
