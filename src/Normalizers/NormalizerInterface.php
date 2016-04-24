<?php


namespace Ionut\Sylar\Normalizers;


interface NormalizerInterface
{
    public function normalize(array $verifiableInformation);
}