<?php


namespace Ionut\Sylar\Normalizers;


use Psr\Http\Message\ServerRequestInterface;

interface NormalizerInterface
{
    public function normalize(ServerRequestInterface $request);
}