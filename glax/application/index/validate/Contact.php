<?php
namespace app\index\validate;
use think\Validate;
/**
 *
 */
class Contact extends Validate
{
    protected $rule = [
        'uname'    =>  'require',
        'email'    =>  'require|email',
        'company'  =>  'require',
        'tel'      =>  'require',
        'message' =>  'require|max:300'
    ];
    protected $message = [
        'uname.require'   => 'A name is required',
        'email.require'   => 'Email is required',
        'email.require'   => 'Email format is incorrect',
        'company.require' => 'The name of the company required',
        'tel.require'     => 'The telephone is required',
        'message.require' => 'The message is required',
        'message.max'     => 'The message must be within 300 characters'
    ];
}
