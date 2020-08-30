<?php


namespace app\services;


interface IEmailService
{
  public function EmailSending($subject,$message,$address);
}