<?php


namespace app\services\Interfaces;


interface IEmailService
{
  public function EmailSending($subject,$message,$address);
}