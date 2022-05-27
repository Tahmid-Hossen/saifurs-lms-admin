<?php

namespace App\Interfaces;

interface ItemInterface
{
    public function getDescriptionAttribute() :? string;

    public function getItemNameAttribute() :? string;

    public function getItemTypeAttribute() :? string;

    public function getItemSourceAttribute();
}
