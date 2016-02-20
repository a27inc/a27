<?php namespace Demo\Service;

interface DemoServiceAwareInterface{
    public function setDemoService(DemoService $s);
}