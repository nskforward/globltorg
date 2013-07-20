<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class feedbackController
{
    public function indexAction()
    {
        ComHTML::load('general');
        ComHTML::load('feedback');
        ComHTML::title('Задать вопрос');
        sideBar::render(null, null, 'question.png');
        ComHTML::dispatch();
    } 
}

?>
