<?php namespace App\Helpers\Classes;

/**
 * Class Socialite.
 */
class SocialiteHelper
{
    /**
     * List of the accepted third party social account types to login with.
     *
     * @return array
     */
    public function getAcceptedSocialAccounts()
    {
        return [
            'bitbucket',
            'facebook',
            'google',
            'github',
            'linkedin',
            'twitter',
        ];
    }
}
