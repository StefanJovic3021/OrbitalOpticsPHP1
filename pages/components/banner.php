<?php
    // Testing banner drawing
    // Actual data (images and text) will come from DB
    $data = [
        [
            'bannerImage' => 'images/slide01.jpg',
            'bannerUpperText' => 'Welcome to <a href="https://templated.co">ORBITAL OPTICS</a> home page',
            'bannerLargeText' => 'Orbital Optics'
        ],
        [
            'bannerImage' => 'images/slide02.jpg',
            'bannerUpperText' => 'Observe stars like never before with our',
            'bannerLargeText' => 'Telescopes'
        ],
        [
            'bannerImage' => 'images/slide03.jpg',
            'bannerUpperText' => 'Map out and plan your perfect stargazing with our',
            'bannerLargeText' => 'Star Maps and Atlases'
        ],
        [
            'bannerImage' => 'images/slide04.jpg',
            'bannerUpperText' => 'Capture perfectly steady shots with our latest',
            'bannerLargeText' => 'Mounts and Tripods'
        ],
        [
            'bannerImage' => 'images/slide05.jpg',
            'bannerUpperText' => 'Rock our newest and out of this world',
            'bannerLargeText' => 'Clothing and Merch'
        ]

    ];

    echo '<section class="banner full">';
    foreach ($data as $smallerArray)
    {
        echo '<article>
                    <img src="'. $smallerArray['bannerImage'] .'" alt="" />
                    <div class="inner">
                        <header>
                            <p>'. $smallerArray['bannerUpperText'] .'</p>
                            <h2>'. $smallerArray['bannerLargeText'] .'</h2>
                        </header>
                    </div>
              </article>';
    }
    echo '</section>';
