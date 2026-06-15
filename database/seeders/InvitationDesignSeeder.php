<?php

namespace Database\Seeders;

use App\Models\InvitationDesign;
use Illuminate\Database\Seeder;


class InvitationDesignSeeder extends Seeder
{

    public function run(): void
    {

        InvitationDesign::updateOrCreate(

            [
                'invitation_id' => '770a3144-67d7-4275-8765-dc802adc0520'
            ],

            [

                'primary_color' => '#bfa15f',

                'background_color' => '#ffffff',

                'text_color' => '#333333',


                'heading_font' => 'Playfair Display',

                'body_font' => 'Montserrat',



                'background_image' => null,

                'cover_image' => null,

                'ornament_image' => null,



                'sections' => [

                    [
                        'type' => 'cover',
                        'order' => 1,
                        'visible' => true
                    ],

                    [
                        'type' => 'quote',
                        'order' => 2,
                        'visible' => true
                    ],

                    [
                        'type' => 'profile',
                        'order' => 3,
                        'visible' => true
                    ],

                    [
                        'type' => 'event',
                        'order' => 4,
                        'visible' => true
                    ],

                    [
                        'type' => 'gallery',
                        'order' => 5,
                        'visible' => true
                    ],

                    [
                        'type' => 'closing',
                        'order' => 6,
                        'visible' => true
                    ],

                ],



                'settings' => [

                    'radius' => '20px',

                    'shadow' => true,

                    'animation' => 'fade-up',

                    'spacing' => 'normal',

                    'button' => [

                        'style' => 'rounded',

                        'size' => 'medium'

                    ]

                ]

            ]

        );

    }

}