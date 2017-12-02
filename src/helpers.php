<?php

if(!function_exists('userModel'))
{
    function userModel()
    {
        return config('socialiser.userModel.fullyNameSpacedUserModel'); //Do not set a default as used for existence test.
    }
}

if(!function_exists('userModelTable'))
{
    function userModelTable()
    {
        return config('socialiser.userModel.userTableName', 'users');
    }
}

if(!function_exists('userPrimaryKeyColumn'))
{
    function userPrimaryKeyColumn()
    {
        return config('socialiser.userModel.userPrimaryKeyColumn', 'id');
    }
}