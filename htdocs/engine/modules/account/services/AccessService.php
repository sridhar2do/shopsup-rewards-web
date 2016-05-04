<?php

namespace engine\modules\account\services;

use engine\components\BaseException;
use engine\components\BaseService;
use engine\modules\account\models\AccRole;
use engine\modules\account\models\AccUserRole;

class AccessService extends BaseService {

    const ROLE_MEMBER = "CONSUMER";
    const ROLE_MODERATOR = "MODERATOR";
    const ROLE_SUPPLIER = "SUPPLIER";

    public function addRole($user, $role) {
        $role = $this->getRoleModel($role);
        $user = AccountService::model()->getUser($user);

        $exist = $this->hasRole($user, $role);
        if($exist) {
            return true;
        }

        $model = AccUserRole::findOne(["user_id"=>$user->id, "role_id"=>$role->id]);
        if(empty($model)) {
            $model = new AccUserRole();
            $model->user_id = $user->id;
            $model->role_id = $role->id;
        }

        $model->is_active = AccUserRole::STATUS_ACTIVE;
        if($model->save()) {
            return true;
        }

        throw new BaseException("Could not add the role.");
    }

    public function removeRole($user, $role) {
        $role = $this->getRoleModel($role);
        $user = AccountService::model()->getUser($user);

        $exist = $this->hasRole($user, $role);
        if(!$exist) {
            return true;
        }

        $model = AccUserRole::findOne(["user_id"=>$user->id, "role_id"=>$role->id, "is_active"=>AccUserRole::STATUS_ACTIVE]);
        $model->is_active = AccUserRole::STATUS_INACTIVE;
        if($model->save()) {
            return true;
        }

        throw new BaseException("Could not remove the role.");
    }

    public function hasRole($user, $role) {
        $role = $this->getRoleModel($role);
        $user = AccountService::model()->getUser($user);

        $result = AccUserRole::findOne(["user_id"=>$user->id, "role_id"=>$role->id, "is_active"=>AccUserRole::STATUS_ACTIVE]);
        if(!empty($result)) {
            return true;
        }

        return false;
    }

    public function getRoleModel($role) {
        if($role instanceof AccRole) {
            return $role;
        }
        try {
            $model = $this->getRoleModelByPK($role, AccRole::STATUS_ACTIVE);
            return $model;
        } catch(BaseException $e) {
            return $this->getRoleModelByName($role, AccRole::STATUS_ACTIVE);
        }
    }

    public function getAllRoleModels($isActive=AccRole::STATUS_ACTIVE) {
        $result = AccRole::findAll(["is_active"=>$isActive]);
        return $result;
    }

    public function getRoleModelByPK($pk,$isActive=AccRole::STATUS_ACTIVE ) {
        $model = AccRole::findOne(["id"=>$pk,"is_active"=>$isActive]);
        if(empty($model)) {
            throw new BaseException("Role could not be found.");
        }
        return $model;
    }

    public function getRoleModelByName($name,$isActive=AccRole::STATUS_ACTIVE) {
        $model = AccRole::findOne(["LOWER(name)"=>strtolower($name),"is_active"=>$isActive]);
        if(empty($model)) {
            throw new BaseException("Role could not be found.");
        }
        return $model;

    }
}