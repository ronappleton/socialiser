<?php

if(!function_exists('userModel'))
{
    function userModel()
    {
        return config('socialiser.userModel.fullyNameSpacedUserModel');
    }
}

if(!function_exists('userModelTable'))
{
    function userModelTable()
    {
        return config('socialiser.userModel.userTableName');
    }
}

if(!function_exists('userPrimaryKeyColumn'))
{
    function userPrimaryKeyColumn()
    {
        return config('socialiser.userModel.userPrimaryKeyColumn');
    }
}

if(!function_exists('getSocialUser'))
{
    function getSocialUser($id, $provider)
    {
        return \RonAppleton\Socialiser\Models\SocialUser::where(['user_id' => $id, 'provider' => $provider])->first();
    }
}