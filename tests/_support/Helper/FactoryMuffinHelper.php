<?php

namespace Helper;

use app\models\Transfer;
use app\models\User;
use Faker\Factory;
use Faker\Generator;
use saada\FactoryMuffin\FactoryMuffin as SaadaFactoryMuffin;

class FactoryMuffinHelper extends \Codeception\Module
{
    /**
     * @var SaadaFactoryMuffin
     */
    private $factory;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @inheritDoc
     */
    public function getModule($name)
    {
        return parent::getModule($name);
    }

    /**
     * @inheritDoc
     */
    public function _initialize()
    {
        date_default_timezone_set('Asia/Almaty');

        $faker = $this->getFaker();

        $this->factory = new SaadaFactoryMuffin();

        $this->factory->define(User::class)->setDefinitions([
            'username'      => $faker->userName,
            'auth_key'      => function () use ($faker) {
                return $faker->md5;
            }
        ]);

        $this->factory->define(Transfer::class)->setDefinitions([
            'sender_id' => 'factory|' . User::class,
            'recipient_id' => 'factory|' . User::class,
            'amount'      => $faker->numberBetween(100, 200),
        ]);
    }

    /**
     * @return \saada\FactoryMuffin\FactoryMuffin
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Define custom actions here
     *
     * @param string $locale
     *
     * @return \Faker\Generator
     */
    public function getFaker($locale = Factory::DEFAULT_LOCALE)
    {
        if (empty($this->faker)) {
            $this->faker = Factory::create($locale);
        }

        return $this->faker;
    }
}
