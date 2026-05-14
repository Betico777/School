<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password'  => $this->passwordRules(),
            'curso_id'  => ['required', 'exists:cursos,id'],
        ])->validate();

        $user = User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => $input['password'],
            'curso_id' => $input['curso_id'],
        ]);

        $estudianteRole = Role::where('name', 'estudiante')->first();
        if ($estudianteRole) {
            $user->assignRole($estudianteRole);
        }

        return $user;
    }
}
