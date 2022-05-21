<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    public function rules()
    {

        return [
            'name' => 'required|unique:marcas,name,' . $this->id . '|min:3',
            'logo' => 'required|image|mimes:jpg,jpeg,png,svg'
        ];
    }

    public function messages()
    {

        return [
            'name.required' => 'O nome é obrigatório',
            'name.unique' => 'Nome da marca já cadastrado ',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres',
            'logo.required' => 'A logo é obrigatória',
            'logo.image' => 'A logo deve ser do tipo imagem',
            'logo.mimes' => 'A logo deve ser do tipo jpg, jpeg ou png'

        ];
    }
}
