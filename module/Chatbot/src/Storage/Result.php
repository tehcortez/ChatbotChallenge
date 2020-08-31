<?php
namespace Chatbot\Storage;

class Result
{

    protected $message;
    const SUCCESS = 1;
    const FAILURE = 0;
    const FAILURE_IDENTITY_NOT_FOUND = -1;
    const FAILURE_IDENTITY_AMBIGUOUS = -2;
    const FAILURE_CREDENTIAL_INVALID = -3;
    const FAILURE_UNCATEGORIZED = -4;

    public function __construct($code, $identity, array $messages = [
        0=>"OH NO! NÃO FOI POSSIVEL COMPLETAR A OPERAÇÃO",
        1=>"HELLO! Welcome, %s",
        -1=>"OH NO! NÃO FOI POSSIVEL ENCONTRAR VOÇÊ",
        -2=>"OH NO! NÃO FOI POSSIVEL COMPLETAR A OPERAÇÃO",
        -3=>"OH NO! SUA SENHA NÃO FOI DIGITADA CORRETAMENTE.",
        -4=>"OH NO! NÃO FOI POSSIVEL COMPLETAR A OPERAÇÃO",
    ]
    )
    {

        switch ($code) {

            case Result::FAILURE:
                $this->setMessage("OH NO! Something went wrong with this operation","error");
                break;

            case Result::SUCCESS:
                $this->setMessage(sprintf($messages[$code],$identity),"success");
                break;

            case Result::FAILURE_IDENTITY_NOT_FOUND:
                $this->setMessage($messages[$code],"alert");
                break;

            case Result::FAILURE_IDENTITY_AMBIGUOUS:
                $this->setMessage($messages[$code],"alert");
                break;

            case Result::FAILURE_CREDENTIAL_INVALID:
                $this->setMessage($messages[$code],"alert");
                break;

            case Result::FAILURE_UNCATEGORIZED:
                $this->setMessage($messages[$code],"error");
                break;

            default:
                $this->message("OH NO! NÃO FOI POSSIVEL COMPLETAR A OPERAÇÃO","error");
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($message,$class='success'){
        $icon['success']='ion-checkmark-round';
        $icon['info']='ion-information-circled';
        $icon['alert']='ion-alert-circled';
        $icon['error']='ion-close-circled';
        $this->message = sprintf("<div class='alert alert_%s'><span>%s<i class='icone %s'></i> </span></div>",$class,$message,$icon[$class]);
    }
}