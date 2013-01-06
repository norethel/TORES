<?php

require_once 'Debugger.php';

final class Dictionaries
{
    const dostawca_elementu = 'dostawca_elementu';
    const dostawca_oprogramowania = 'dostawca_oprogramowania';
    const producent_elementu = 'producent_elementu';
    const producent_oprogramowania = 'producent_oprogramowania';
    const status_pracownika = 'status_pracownika';
    const typ_elementu = 'typ_elementu';
    const typ_licencji = 'typ_licencji';
    const typ_oprogramowania = 'typ_oprogramowania';

    private function Dictionaries() {}
}

final class Objects
{
    const Element = 'element';
    const Oprogramowanie = 'oprogramowanie';
    const Pokwitowanie = 'pokwitowanie';
    const Pracownik = 'pracownik';
    const Sprzet = 'sprzet';

    private function Objects() {}
}

abstract class ObjectBase
{
    protected function init($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        if (!empty($attributes))
        {
            $i = 0;

            foreach (get_object_vars($this) as $prop => $val)
            {
                $this->$prop = $attributes[$i];
                $i++;
            }
        }

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }

    public function getAttributes()
    {
        return get_object_vars($this);
    }

    public function getSetAttributes()
    {
        DBG::log(__CLASS__, __FUNCTION__, 'all:', get_object_vars($this));

        $attributes = array();

        foreach (get_object_vars($this) as $param => $value)
        {
            if (!is_null($value))
            {
                $attributes[$param] = $value;
            }
        }

        DBG::log(__CLASS__, __FUNCTION__, 'only those set:', $attributes);

        return $attributes;
    }
}

final class Element extends ObjectBase
{
    public $id;
    public $typ_elementu_id;
    public $producent_elementu_id;
    public $model;
    public $cecha1;
    public $cecha2;
    public $cecha3;
    public $cecha4;
    public $nr_seryjny;
    public $nr_wniosku_zakupu;
    public $faktura;
    public $data_zakupu;
    public $gwarancja;
    public $dostawca_elementu_id;
    public $ilosc;
    public $foto_czesci;
    public $pokwitowanie_id;

    public function Element($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Oprogramowanie extends ObjectBase
{
    public $id;
    public $nazwa;
    public $producent_id;
    public $dostawca_id;
    public $typ_oprog_id;
    public $typ_licencji_id;
    public $l_licencji;
    public $l_wyk_licencji;
    public $data_zakupu;
    public $upgrade;
    public $data_upgrade;
    public $downgrade;
    public $data_downgrade;
    public $nr_dok_pwn;
    public $pokwitowanie_id;

    public function Oprogramowanie($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Pokwitowanie extends ObjectBase
{
    public $id;
    public $pracownik_id;
    public $kto;
    public $komu;
    public $czego;
    public $data_czynnosci;
    public $wydal;
    public $odebral;

    public function Pokwitowanie($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Pracownik extends ObjectBase
{
    public $id;
    public $us_is;
    public $komorka;
    public $pokoj;
    public $uprawnienia;
    public $status;

    public function Pracownik($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Sprzet extends ObjectBase
{
    public $id;
    public $nr_inwentarzowy;
    public $kod_sprzetu;
    public $pracownik_id;

    public function Sprzet($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Sprzet_Element extends ObjectBase
{
    public $id;
    public $sprzet_id;
    public $element_id;

    public function Sprzet_Element($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

final class Sprzet_Oprogramowanie extends ObjectBase
{
    public $id;
    public $sprzet_id;
    public $oprogramowanie_id;

    public function Sprzet_Oprogramowanie($attributes)
    {
        DBG::log(__CLASS__, __FUNCTION__, 'before:', get_object_vars($this));

        parent::init($attributes);

        DBG::log(__CLASS__, __FUNCTION__, 'after:', get_object_vars($this));
    }
}

?>