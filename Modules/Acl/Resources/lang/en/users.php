<?php

use Modules\Acl\Enums\UserStatusEnum;

return [
    'delete_user_logged_in'      => 'Can\'t delete this user. This user is logged on!',
    'no_select'                  => 'Please select at least one record to take this action!',
    'lock_user_logged_in'        => 'Can\'t lock this user. This user is logged on!',
    'update_success'             => 'Update status successfully!',
    'save_setting_failed'        => 'Something went wrong when save your setting',
    'not_found'                  => 'User not found',
    'email_exist'                => 'That email address already belongs to an existing account',
    'username_exist'             => 'That username address already belongs to an existing account',
    'update_profile_success'     => 'Your profile changes were successfully saved',
    'password_update_success'    => 'Password successfully changed',
    'current_password_not_valid' => 'Current password is not valid',
    'user_exist_in'              => 'User is already a member',
    'email'                      => 'Email',
    'role'                       => 'Role',
    'username'                   => 'Username',
    'last_name'                  => 'Last Name',
    'first_name'                 => 'First Name',
    'message'                    => 'Message',
    'cancel_btn'                 => 'Cancel',
    'change_password'            => 'Change password',
    'current_password'           => 'Current password',
    'new_password'               => 'New Password',
    'confirm_new_password'       => 'Confirm New Password',
    'password'                   => 'Password',
    'save'                       => 'Save',
    'cannot_delete'              => 'User could not be deleted',
    'deleted'                    => 'User deleted',
    'last_login'                 => 'Last Login',
    'error_update_profile_image' => 'Error when update profile image',
    'email_reminder_template'    => '<h3>Hello :name</h3><p>The system has received a request to restore the password for your account, to complete this task please click the link below.</p><p><a href=":link">Reset password now</a></p><p>If not you ask recover password, please ignore this email.</p><p>This email is valid for 60 minutes after receiving the email.</p>',
    'change_profile_image'       => 'Change Profile Image',
    'new_image'                  => 'New Image',
    'loading'                    => 'Loading',
    'close'                      => 'Close',
    'update'                     => 'Update',
    'read_image_failed'          => 'Failed to read the image file',
    'users'                      => 'Users',
    'update_avatar_success'      => 'Update profile image successfully!',
    'info'                       => [
        'title'                => 'User profile',
        'first_name'           => 'First Name',
        'last_name'            => 'Last Name',
        'email'                => 'Email',
        'second_email'         => 'Secondary Email',
        'address'              => 'Address',
        'second_address'       => 'Secondary Address',
        'birth_day'            => 'Date of birth',
        'job'                  => 'Job Position',
        'mobile_number'        => 'Mobile Number',
        'second_mobile_number' => 'Secondary Phone',
        'interes'              => 'Interests',
        'about'                => 'About',

    ],
    'gender'                     => [
        'title'  => 'Gender',
        'male'   => 'Male',
        'female' => 'Female',
    ],
    'total_users'                => 'Total users',
    'statuses'                   => [
        UserStatusEnum::ACTIVATED   => 'Activated',
        UserStatusEnum::DEACTIVATED => 'Deactivated',
    ],
    'make_super'                 => 'Make super',
    'remove_super'               => 'Remove super',
    'is_super'                   => 'Is super?',
    'email_placeholder'          => 'Ex: example@gmail.com',
    'password_confirmation'      => 'Re-type password',
    'select_role'                => 'Select role',
    'create_new_user'            => 'Create a new user',
    'cannot_delete_super_user'   => 'Permission denied. Cannot delete a super user!',
];
