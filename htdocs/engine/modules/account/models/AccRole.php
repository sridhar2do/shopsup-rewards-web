<?php

namespace engine\modules\account\models;

use engine\modules\account\models\AccRoleBase;


class AccRole extends AccRoleBase {

    const ROLE_CONSUMER = "CONSUMER";
    const ROLE_SUPPLIER = "SUPPLIER";
    const ROLE_MODERATOR = "MODERATOR";

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

}