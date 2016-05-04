<?php

namespace api\components;

class APIMessages
{
    const ERROR_DATA_FAILED_TO_SAVE = "Could not save the data in the database. MySQL error.";
    const ERROR_DATA_VALIDATION = "Invalid data. Please revalidate the user input.";
    const ERROR_AUTHENTICATION_FAILED = "Bad Credentials. Incorrect username or password.";
    const ERROR_RESOURCE_NOT_FOUND = "The requested resource could not be found.";
    const ERROR_UNKNOWN = "The server encountered an unknown error and could not recover.";
    const ERROR_RESOURCE_EXPIRED = "The specified resource expired.";
    const ERROR_BAD_REQUEST = "Missing required parameters";
    const ERROR_DATA_INCONSISTENT = "The database has inconsistent data. - ";

    const SUCCESS_GENERIC = "The operation was completed successfully.";
}


?>