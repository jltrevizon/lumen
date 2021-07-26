<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class CampaUserRepository extends Repository {

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($request){

        $campas = $request->input('campas');
        foreach($campas as $campa){
            DB::table('campa_user')->insert([
                'campa_id' => $campa,
                'user_id' => $request->input('user_id')
            ]);
        }
        return $this->userRepository->getById($request->input('user_id'));
    }

    public function delete($request){
        $campas = $request->input('campas');
        foreach($campas as $campa){
            DB::table('campa_user')
            ->where('user_id',$request->input('user_id'))
            ->where('campa_id', $campa)
            ->delete();
        }
        return ['message' => 'campas deleted'];

    }

}
