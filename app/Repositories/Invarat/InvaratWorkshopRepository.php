<?php

namespace App\Repositories\Invarat;

use App\Models\Accessory;
use App\Models\Vehicle;
use App\Models\Workshop;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class InvaratWorkshopRepository {

    public function __construct(
        InvaratUserRepository $invaratUserRepository,
        UserRepository $userRepository
        )
    {
        $this->invaratUserRepository = $invaratUserRepository;
        $this->userRepository = $userRepository;
    }

    public function createWorkshop($workshop){
        $workshopExist = Workshop::where('cif', $workshop['cif'])
                    ->first();
        $user = $this->userRepository->getUserByEmail($workshop['email']);
        if($workshopExist){
            if(!$user){
                $user = $this->invaratUserRepository->createUser($workshop['email'], $workshopExist->id);
            }
            return [
                'user' => $user,
                'workshop' => $workshopExist
            ];
        }
        $newWorkshop = new Workshop();
        $newWorkshop->name = $workshop['name'];
        $newWorkshop->cif = $workshop['cif'];
        $newWorkshop->province = $workshop['province'];
        $newWorkshop->location = $workshop['location'];
        $newWorkshop->address = $workshop['address'];
        $newWorkshop->phone = $workshop['phone'];
        $newWorkshop->save();
        $user = $this->invaratUserRepository->createUser($workshop['email'], $newWorkshop->id);
        return [
            'user' => $user,
            'workshop' => $newWorkshop
        ];
    }

}
