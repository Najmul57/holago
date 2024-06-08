<?php

namespace App\Http\Traits;


trait ManageTemplate
{

	protected function getTemplateSection()
    {
    	$array 	=	[

			'banner'				=>	[
				'name'				=>	'Banner Section',
				'single_item'		=>	[],
                'multiple_item'	=>	[

					'button_name'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					'button_url'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png,gif',
						'is_image'	=>	true,
						'size'		=>	'1878x715'
					],
                    'is_modal'		=>	true
				],
			],

			'refresh'				=>	[
				'name'				=>	'Refresh Section',
				'single_item'		=>	[

					'title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					
					'first_title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					
					'second_title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					
					'third_title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					
					'button_name'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					'button_url'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png,gif',
						'is_image'	=>	true,
						'size'		=>	'1708x2560'
					],
				],
			],


			'vintage'				=>	[
				'name'				=>	'Vintage Section',
				'single_item'		=>	[

					'title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],

					'content'			=>	[
						'type'		=>	'textarea',
						'require'	=>	false,
						'rich' => false
					],
					'link_name'			=>	[
						'type'		=>	'text',
						'require'	=>	true
					],
					'link'			=>	[
						'type'		=>	'text',
						'require'	=>	true
					],
				],

				'multiple_item'	=>	[

					'title'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'icon'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'link'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png',
						'is_image'	=>	true,
						'size'		=>	'337x344'
					],

					'is_modal'		=>	true
				],
			],


			'vision'				=>	[
				'name'				=>	'Our Vision Section',
				'single_item'		=>	[

					'title_top'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'title'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'color_title'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'title_buttom'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'content'		=>	[
						'type'		=>	'textarea',
						'required'	=>	true,
						'rich'		=>  false
					],

					'button_name'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'button_link'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png,gif',
						'is_image'	=>	true,
						'size'		=>	'610x430'
					],
				],
			],

			'newsletter'				=>	[
				'name'				=>	'Newsletter Section',
				'single_item'		=>	[

					'title'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'color_title'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],
				],
			],

			'about'					=>	[
				'name'				=>	'About Section',
				'single_item'		=>	[

					'title' 		=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'color_title' 		=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'sub_title' 		=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'content_title' 		=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'content' 		=>	[
						'type'		=>	'textarea',
						'required'	=>	true,
						'rich'		=>	false
					],

					'button_name' 		=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'button_link' 	=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png',
						'is_image'	=>	true,
						'size'		=>	'633x442'
					],
				],

			],

			'blog'				=>	[
				'name'				=>	'Career Tips Section',
				'single_item'		=>	[

					'title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],

					'color_title'			=>	[
						'type'		=>	'text',
						'require'	=>	false
					],
					'sub_title'			=>	[
						'type'		=>	'text',
						'require'	=>	true
					],
				],

				'multiple_item'	=>	[

					'title'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'description'			=>	[
						'type'		=>	'textarea',
						'required'	=>	true,
						'rich'		=>	true
					],

					'image'			=>	[
						'type'		=>	'file',
						'required'	=>	true,
						'mimes'		=>	'jpg,jpeg,png',
						'is_image'	=>	true,
						'size'		=>	'866x578'
					],

					'is_modal'		=>	false
				],
			],


			'social_account'				=>	[
				'name'				=>	'Social Account Section',
				'single_item'		=>	[],

				'multiple_item'	=>	[

					'icon'			=>	[
						'type'		=>	'text',
						'required'	=>	true
					],

					'link'			=>	[
						'type'		=>	'text',
						'required'	=>	false
					],

					'is_modal'		=>	true
				],
			],

			'contact'				=>	[
				'name'				=>	'Contact Section',
				'single_item'		=>	[

					'trade_license'			=>	[
							'type'=>'text',
							'required'=>false
					],

					'phone'			=>	[
							'type'=>'text',
							'required'=>true
					],

					'email'			=>	[
							'type'=>'text',
							'required'=>true
					],

					'address'			=>	[
							'type'		=>'text',
							'required'	=>true
					],

				],
			],

			'usefull_links'=>[

				'name'=>'Usefull Links',

                	'single_item'	=>	[],

					'multiple_item'	=>	[

						'title'		=>	[
							'type'=>'text',
							'required'=>true
						],

						'content'	=>	[
							'type'	=>	'textarea',
							'required'	=>	true,
							'rich'	=>	true
						],

						'is_modal'	=>	false
					],
			],
		];
		return $array;
    }

}
