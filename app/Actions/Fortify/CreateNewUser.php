<?php

namespace App\Actions\Fortify;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'login'=>[
                'required',
                 'string',
                 'regex:/^[a-zA-Z0-9]+$/',
                 'min:6',
                 Rule::unique(User::class),
            ],
            'phone'=>[
                'required',
                 'string',
                 'regex:/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
                 Rule::unique(User::class),
            ],
            'name' => [
                'required',
                 'string',
                  'max:255',
                  'regex:/^[а-яА-ЯёЁ ]+$/u'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ],[
            //login
            'login.required'=>'Логин обязателен',
            'login.min'=>'Логин должен содержать как миниму 6 символов ',
            'login.regex'=>'Логин должен содрежать только латиницу и цифры',
            'login.unique'=>'Логин должен быть уникальным',
            //phone
            'phone.required'=>'телефон обязателен',
            'phone.regex'=>'Телефон должен быть в формате 8 (ХХХ)ХХХ-ХХ-ХХ',
            'phone.unique'=>'Телефон должен быть уникальным',
            //name
            'name.required'=>'фио обязателен',
            'name.regex'=>'ФИО должен содрежать только кирилицу',
            'name.max'=>'Превышен лимит символов в 255',
            //email
            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Этот email уже зарегистрирован',
            //pass
             'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.regex' => 'Пароль должен содержать заглавные и строчные буквы, а также цифры',
        ])->validate();

        return User::create([
            'login' => $input['login'],
            'email' => $input['email'],
            'name' => $input['name'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
            'type' => 'user',
        ]);
    }
}

