<?php

// "Workout Title" => [
//     "description" => "Workout Description",
//     "goal_id" => "Lose, Gain, Maintain",
//     "level_id" => "Beginner, Intermediate, Advance",
//     "type_id" => 13,
//     "place_type" => "1 => GYM, 2 => HOME",
//     "days" => [
//         "one" => [
//             "body part" => ["exercises"]
//         ]
//     ]
// ]


return [

    # Beginner I Section

    "Type 4 - GYM - 3 days Beginner I" => [
        "description" => "Type 4 - GYM - 3 days Beginner I",
        "goal_id" => 1,
        "level_id" => 1,
        "type_id" => 4,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [120, 75, 121],
                1 => [140, 276, 278],
                10 => [176, 177, 60],
                1 => [185, 83,],
            ],
            "three" => [
                13 => [154, 85, 166],
                4 => [132, 148, 173],
                1 => [76, 144, 375],
                5 => [255, 227, 267],
            ],
            "six" => [
                3 => [95, 77, 128],
                12 => [107],
                6 => [257, 256, 253]
            ]
        ],

    ],

    "Type 7 - GYM - 4 days Beginner I" => [
        "description" => "Type 7 - GYM - 4 days Beginner I",
        "goal_id" => 1,
        "level_id" => 1,
        "type_id" => 7,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [108, 110, 121],
                10 => [178, 15, 63],
                6 => [193, 194, 302],
                3 => [71, 95, 192],
            ],
            "two" => [
                13 => [165, 161, 26, 86],
                4 => [1, 130, 7],
            ],
            "five" => [
                1 => [70, 83, 76],
                5 => [268, 269, 304],
                7 => [374, 378],
                9 => [109]
            ],
            "six" => [
                3 => [77, 71],
                11 => [73, 96, 77],
                15 => [97],
                12 => [317, 107]
            ]
        ]
    ],

    "Type 10 - GYM - 5 days Beginner " => [
        "description" => "Type 10 - GYM - 5 days Beginner ",
        "goal_id" => 1,
        "level_id" => 1,
        "type_id" => 10,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [108, 120, 50],
                2 => [199, 53, 56],
                5 => [226, 230, 300]
            ],
            "two" => [
                13 => [155, 100, 26],
                6 => [250, 193, 305]
            ],
            "three" => [
                1 => [70, 27, 144],
                5 => [304, 307, 266]
            ],
            "five" => [
                3 => [95, 128],
                11 => [292,],
                12 => [294, 272]
            ],
            "six" => [
                4 => [10, 130, 289],
                10 => [178, 377, 182],
                7 => [249, 378, 374]
            ]
        ],
    ],

    "Type 13 - GYM - 6 days Beginner I" => [
        "description" => "Type 13 - GYM - 6 days Beginner I",
        "goal_id" => 1,
        "level_id" => 1,
        "type_id" => 13,
        "place_type" => 1,
        "days" => [
            "one" => [
                3 => [123, 24, 79, 80],
                11 => [292, 96, 309],
                14 => [97]
            ],
            "two" => [
                2 => [108, 110, 121],
                10 => [201, 179, 177],
                5 => [260, 261, 191]
            ],
            "three" => [
                13 => [156, 160, 159],
                4 => [10, 30, 28],
                6 => [305, 253, 257]
            ],
            "four" => [
                1 => [70, 83, 275],
                7 => [374, 249],
                12 => [107, 272, 294]
            ],
            "five" => [
                13 => [105],
                1 => [144, 16],
                2 => [45, 50],
                10 => [201],
                4 => [38],
                6 => [305],
                5 => [226, 269]
            ],
            "six" => [
                16 => [209, 205],
            ]
        ]
    ],

    #Intermediate I Section

    "Type 5 - GYM - 3 Days Intermediate I" => [
        "description" => "Type 5 - GYM - 3 Days Intermediate I",
        "goal_id" => 1,
        "level_id" => 2,
        "type_id" => 5,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [121, 48, 52, 196],
                1 => [18, 72, 41],
                10 => [63, 69, 15, 201],
                1 => [188, 83, 143],
            ],
            "three" => [
                13 => [156, 85, 163, 202],
                4 => [13, 130, 39, 36],
                1 => [275, 375, 27],
                13 => [157, 167, 42],
            ],
            "six" => [
                3 => [129, 129, 78],
                11 => [292, 73],
                14 => [97, 222],
                12 => [272, 294, 25],
                5 => [227, 118, 263, 262],
            ]
        ]
    ],

    "Type 8 - GYM - 4 days Intermediate I" => [
        "description" => "Type 8 - GYM - 4 days Intermediate I",
        "goal_id" => 1,
        "level_id" => 2,
        "type_id" => 8,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [110, 52, 57, 139],
                10 => [182, 180, 377, 91],
                6 => [254, 194, 256, 305]
            ],
            "two" => [
                13 => [154, 164, 159, 117],
                4 => [1, 11, 289, 7],
                7 => [374, 378, 249],
                // 16 => []
            ],
            "five" => [
                11 => [73],
                12 => [272, 294, 25,]
            ],
            "six" => [
                1 => [27, 376, 185, 83],
                1 => [43, 144, 122],
                9 => [109, 187],
                5 => [268, 229, 270, 255],
                // 16 => []
            ]

        ]


    ],

    "Type 11 - GYM - 5 days Intermediate I" => [
        "description" => "Type 11 - GYM - 5 days Intermediate I",
        "goal_id" => 1,
        "level_id" => 2,
        "type_id" => 11,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [108, 199],
                13 => [155, 26],
                4 => [1, 151],
                10 => [182, 177],
                1 => [278, 17],
                9 => [185],
                5 => [226, 300],
            ],
            "two" => [
                3 => [281, 282, 77],
                11 => [73, 292],
                14 => [81,],
                12 => [107],
                6 => [250,],
            ],
            "three" => [
                2 => [198, 75, 139],
                13 => [105, 44, 117],
                // 16 => [],
            ],
            "five" => [
                3 => [95, 128, 77],
                11 => [292, 309],
                12 => [294, 272],
                14 => [97, 298,],
                5 => [270, 261],
            ],
            "six" => [
                4 => [10, 289],
                10 => [377, 178],
                1 => [18, 144, 17],
                1 => [378, 374],
                7 => [378, 374,],
            ]
        ]
    ],

    "Type 14 - GYM - 6 days Intermediate I" => [
        "description" => "Type 14 - GYM - 6 days Intermediate I",
        "goal_id" => 1,
        "level_id" => 2,
        "type_id" => 14,
        "place_type" => 1,
        "days" => [
            "one" => [
                3 => [77, 24, 79, 80],
                11 => [292,],
                13 => [339],
                14 => [308, 97, 223],
                12 => [107],
            ],
            "two" => [
                2  => [108, 110, 121],
                1  => [140, 83],
                10  => [83, 181, 177],
                5  => [260, 304, 191],
            ],
            "three" => [
                13 => [157, 159, 43, 167],
                4 => [32, 38,],
                1 => [76, 375],
                9 => [293],
                6 => [194, 257],
            ],
            "four" => [
                3 => [77, 24, 79, 80],
                11 => [292],
                13 => [339,],
                14 => [308, 97, 223],
                12 => [107],
            ],
            "five" => [
                2 => [52, 56, 75],
                1 => [278, 18, 17, 27],
                10 => [201, 201, 58],
                5 => [229],
            ],
            "six" => [
                13 => [105, 44, 156],
                1 => [144,],
                4 => [10, 149],
                9 => [109],
                6 => [254, 256],
            ],
        ]
    ],

    #Intermediate I Section

    "Type 6 - GYM - 3 days Advance I" => [
        "description" => "Type 6 - GYM - 3 days Advance I",
        "goal_id" => 1,
        "level_id" => 3,
        "type_id" => 6,
        "place_type" => 1,
        "days" => [
            "one" => [
                3 => [129],
                2 => [108, 57, 199],
                1 => [70, 330, 83],
                13 => [44, 157],
                10 => [63, 69, 293],
                9 => [185, 293],
                5 => [228],
            ],
            "three" => [
                3 => [128, 26, 95, 297],
                11 => [96, 73],
                13 => [26, 288],
                2 => [198, 137],
                1 => [16, 275],
                4 => [130, 174],
                5 => [227, 263],
            ],
            "six" => [
                3 => [80,],
                // 14 => [],
                12 => [294, 25],
                13 => [154, 167],
                2 => [198],
                1 => [278, 115, 165],
                10 => [115, 201],
                6 => [254],
            ]
        ]
    ],

    "Type 9 - GYM - 4 days Advance I" => [
        "description" => "Type 9 - GYM - 4 days Advance I",
        "goal_id" => 1,
        "level_id" => 3,
        "type_id" => 9,
        "place_type" => 1,
        "days" => [
            "one" => [
                2 => [110, 52, 75, 53],
                2 => [55, 199, 139,],
                10 => [178, 181, 182, 377],
                6 => [257, 256],
            ],
            "two" => [
                13 => [154, 160, 165, 44],
                13 => [163, 368, 157, 117],
                4 => [13, 36, 149, 7],
                7 => [374, 378, 249],
                // 16 => [],
            ],
            "five" => [
                1 => [149, 145, 70, 277],
                1 => [188, 278, 17],
                1 => [143, 375,],
                9 => [111, 293],
                5 => [267, 301],
            ],
            "six" => [
                14 => [97, 81, 274],
                3 => [20, 95, 128, 322],
                11 => [73, 292],
                12 => [272],
                16 => [203],
            ]
        ]
    ],

    "Type 12 - GYM - 5 days Advance I" => [
        "description" => "Type 12 - GYM - 5 days Advance I",
        "goal_id" => 1,
        "level_id" => 3,
        "type_id" => 12,
        "place_type" => 1,
        "days" => [
            "one" => [
                13 => [26, 105, 50],
                2 => [47],
                1 => [18, 76],
                4 => [102],
                10 => [69],
                9 => [109],
                5 => [229, 255, 300],
            ],
            "two" => [
                3 => [77, 128, 220],
                11 => [292, 73],
                14 => [274],
                13 => [26],
                12 => [294, 107],
                6 => [254, 305],
            ],
            "three" => [
                2 => [110, 137, 139],
                2 => [134, 108],
                13 => [86, 85, 117],
                13 => [167, 168],
            ],
            "five" => [
                3 => [192, 128, 95],
                3 => [71],
                11 => [73],
                12 => [294, 272],
                14 => [274, 294],
            ],
            "six" => [
                1 => [278, 276, 17, 76],
                4 => [132, 150],
                10 => [178, 64],
                7 => [374, 378],
            ]
        ]
    ],

    "Type 15 - GYM - 6 days Advance I" => [
        "description" => "Type 15 - GYM - 6 days Advance I",
        "goal_id" => 1,
        "level_id" => 3,
        "type_id" => 15,
        "place_type" => 1,
        "days" => [
            "one" => [
                3 => [71, 79, 95, 80, 283],
                13 => [26],
                11 => [73],
                14 => [308],
                12 => [294, 97],
            ],
            "two" => [
                2 => [121, 120, 108],
                1 => [41, 70, 17],
                10 => [176, 201],
                5 => [229],
            ],
            "three" => [
                13 => [154, 159, 26],
                13 => [157, 105, 43],
                1 => [275],
                9 => [295],
                4 => [8, 287],
                6 => [256],
            ],
            "four" => [
                16 => [272],
            ],
            "five" => [
                5 => [17, 226],
            ],
            "six" => [
                6 => [256],
            ],
        ]
    ],
];
