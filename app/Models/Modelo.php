<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_id', 'name', 'image', 'number_doors', 'benches', 'air_bag', 'abs'];

    public function rules()
    {

        return [
            'marca_id' => 'required|exists:marcas,id',
            'name' => 'required|unique:modelos,name,' . $this->id . '|min:3',
            'image' => 'required|mimes:jpg,jpeg,png,svg|image',
            'number_doors' => 'required|integer|digits_between:1,4',
            'benches' => 'required|integer|digits_between:1,8',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'

        ];
    }

    public function messages()
    {
        return [
            'marca_id.required' => 'A marca é obrigatória',
            'marca_id.exists' => 'Deve ser informada o id de uma marca válida',
            'name.required' => 'O nome é obrigatório',
            'name.unique' => 'Nome do modelo já está cadastrado',
            'name.min' => 'O nome do modelo deve ter no mínimo 3 caracteres',
            'image.required' => 'A imagem é obrigatória',
            'image.mimes' => 'A imagem deve ser do tipo:jpg, jpeg, png ou svg',
            'image.image' => 'O formato deve ser uma imagem',
            'number_doors.required' => 'A quantidade de portas é obrigatório',
            'number_doors.integer' => 'O número de portas deve ser um valor inteiro',
            'number_doors.digits_between' => 'A quantidade de portas deve ser um número entre 1 e 4',
            'benches.required' => 'A quantidade de lugares é obrigatório',
            'benches.integer' => 'O número de lugares deve ser um valor inteiro',
            'benches.digits_between' => 'A quantidade de lugares deve ser um número entre 1 e 8',
            'air_bag.required' => 'O campo airbag é obrigatório',
            'air_bag.boolean' => 'O campo airbarg deve ser true ou false',
            'abs.required' => 'O campo abs é obrigatório',
            'abs_bag.boolean' => 'O campo abs deve ser true ou false',

        ];
    }

    public function marca()
    {
        return $this->hasOne(Marca::class, 'id', 'marca_id');
    }
}
