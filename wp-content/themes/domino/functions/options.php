<?php return array(


/* Theme Admin Menu */
"menu" => array(
    array("id"    => "1",
          "name"  => "General"),

    array("id"    => "2",
          "name"  => "Homepage"),

  	array("id"    => "7",
          "name"  => "Banners"),
),

/* Theme Admin Options */
"id1" => array(
    array("type"  => "preheader",
          "name"  => "Theme Settings"),

   array("type" => "startsub",
         "name" => "Breaking News Bar"),

   array("name"  => "Display Breaking News Bar?",
         "desc"  => "Edit posts which you want to display here, and check the option from editing page: <strong>Add to Breaking News Bar</strong> ",
         "id"    => "breaking_on",
         "std"   => "on",
         "type"  => "checkbox"),

   array("name"  => "Number of Posts",
         "desc"  => "Default: <strong>5</strong> (posts).",
         "id"    => "breaking_number",
         "std"   => "5",
         "type"  => "text"),

   array("type"  => "endsub"),

    array("name"  => "Custom Feed URL",
          "desc"  => "Example: <strong>http://feeds.feedburner.com/wpzoom</strong>",
          "id"    => "misc_feedburner",
          "std"   => "",
          "type"  => "text"),

 	array("name"  => "Enable comments on static pages",
          "id"    => "comments_page",
          "std"   => "off",
          "type"  => "checkbox"),

    array(
      "name" => "Display WooCommerce Cart Button in the Header?",
      "id" => "cart_icon",
      "std" => "on",
      "type" => "checkbox"
    ),


 	array(
          "type" => "preheader",
          "name" => "Global Posts Options"
      ),


    array(
        "name" => "Display Featured Image at the Top",
        "id" => "display_thumb",
        "std" => "on",
        "type" => "checkbox"
    ),

    array(
          "name" => "Display Excerpt",
          "desc" => "Number of posts displayed on homepage can be changed <a href=\"options-reading.php\" target=\"_blank\">here</a>.",
          "id" => "display_content",
          "std" => "on",
          "type" => "checkbox"
      ),

      array(
          "name" => "Excerpt length",
          "desc" => "Default: <strong>50</strong> (words)",
          "id" => "excerpt_length",
          "std" => "50",
          "type" => "text"
      ),

      array(
          "name" => "Display Category",
          "id" => "display_category",
          "std" => "on",
          "type" => "checkbox"
      ),


      array(
          "name" => "Display Date/Time",
          "desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
          "id" => "display_date",
          "std" => "on",
          "type" => "checkbox"
      ),

      array(
          "name" => "Display Author",
          "id" => "display_author",
          "std" => "on",
          "type" => "checkbox"
      ),

      array(
          "name" => "Display Comments Count",
          "id" => "display_comments",
          "std" => "on",
          "type" => "checkbox"
      ),


      array(
          "name" => "Display Read More Button",
          "id" => "display_more",
          "std" => "on",
          "type" => "checkbox"
      ),

	array("type"  => "preheader",
          "name"  => "Single Post Options"),

    array("name"  => "Display Featured Image at the Top",
          "id"    => "post_thumb",
          "std"   => "off",
          "type"  => "checkbox"),

	array("name"  => "Display Category",
          "id"    => "post_category",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Display Author",
          "desc"  => "You can edit your profile on this <a href='profile.php' target='_blank'>page</a>.",
          "id"    => "post_author",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Display Date/Time",
          "desc"  => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
          "id"    => "post_date",
          "std"   => "on",
          "type"  => "checkbox"),


    array("name"  => "Display Related Posts",
         "id"    => "post_related",
         "std"   => "on",
         "type"  => "checkbox"),



    array("name"  => "Display Tags",
          "id"    => "post_tags",
          "std"   => "on",
          "type"  => "checkbox"),


    array(
        "name" => "Display Author Profile",
        "desc" => "You can edit your profile on this <a href='profile.php' target='_blank'>page</a>.",
        "id" => "post_author_box",
        "std" => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => "Display Comments",
        "id" => "post_comments",
        "std" => "on",
        "type" => "checkbox"
    ),

),

"id2" => array(


 	array("type"  => "preheader",
             "name"  => "Homepage Slideshow"),

       array("name"  => "Display Slideshow on homepage?",
             "desc"  => "Do you want to show a featured slider on the homepage? To add posts in slider just check the option <strong>Featured in Homepage Slider</strong> in the post.",
             "id"    => "featured_posts_show",
             "std"   => "on",
             "type"  => "checkbox"),

        array("name"  => "Title for Featured Slideshow",
               "desc"  => "Default: <em>Featured</em>",
               "id"    => "featured_title",
               "std"   => "Featured",
               "type"  => "text"),

       array("name"  => "Autoplay Slideshow?",
             "desc"  => "Do you want to auto-scroll the slides?",
             "id"    => "slideshow_auto",
             "std"   => "off",
             "type"  => "checkbox",
             "js"    => true),

       array("name"  => "Slider Autoplay Interval",
             "desc"  => "Select the interval (in miliseconds) at which the Slider should change posts (<strong>if autoplay is enabled</strong>). Default: 3000 (3 seconds).",
             "id"    => "slideshow_speed",
             "std"   => "3000",
             "type"  => "text",
             "js"    => true),

       array("name"  => "Number of Posts in Slider",
             "desc"  => "How many posts should appear in  Slider on the homepage? Default: 5.",
             "id"    => "slideshow_posts",
             "std"   => "5",
             "type"  => "text"),


       array(
           "name" => "Display Category",
           "id" => "slider_category",
           "std" => "on",
           "type" => "checkbox"
       ),

       array(
           "name" => "Display Date/Time",
           "desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
           "id" => "slider_date",
           "std" => "on",
           "type" => "checkbox"
       ),

       array(
           "name" => "Display Comments Count",
           "id" => "slider_comments",
           "std" => "on",
           "type" => "checkbox"
       ),



	array("type"  => "preheader",
          "name"  => "Recent Posts"),

	array("name"  => "Display Recent Posts on Homepage",
          "id"    => "recent_posts",
          "std"   => "on",
          "type"  => "checkbox"),

  	array("name"  => "Title for Recent Posts",
          "desc"  => "Default: <em>Other News</em>",
          "id"    => "recent_title",
          "std"   => "Other News",
          "type"  => "text"),

	array("name"  => "Exclude categories",
          "desc"  => "Choose the categories which should be excluded from the main Loop on the homepage.<br/><em>Press CTRL or CMD key to select/deselect multiple categories </em>",
          "id"    => "recent_part_exclude",
          "std"   => "",
          "type"  => "select-category-multi"),

	array("name"  => "Hide Featured Posts in Recent Posts?",
          "desc"  => "You can use this option if you want to hide posts which are featured in the slider on front page.",
          "id"    => "hide_featured",
          "std"   => "on",
          "type"  => "checkbox")
),




"id7" => array(
    array("type"  => "preheader",
          "name"  => "Header Ad"),

    array("name"  => "Enable ad space in the header?",
          "id"    => "ad_head_select",
          "std"   => "off",
          "type"  => "checkbox"),

    array("name"  => "HTML Code (Adsense)",
          "desc"  => "Enter complete HTML code for your banner (or Adsense code) or upload an image below.",
          "id"    => "ad_head_code",
          "std"   => "",
          "type"  => "textarea"),

    array("name"  => "Upload your image",
          "desc"  => "Upload a banner image or enter the URL of an existing image.<br/>Recommended size: <strong>728 × 90px</strong>",
          "id"    => "banner_top",
          "std"   => "",
          "type"  => "upload"),

    array("name"  => "Destination URL",
          "desc"  => "Enter the URL where this banner ad points to.",
          "id"    => "banner_top_url",
          "type"  => "text"),

    array("name"  => "Banner Title",
          "desc"  => "Enter the title for this banner which will be used for ALT tag.",
          "id"    => "banner_top_alt",
          "type"  => "text"),


	array("type"  => "preheader",
          "name"  => "Sidebar Ad"),

	array("name"  => "Enable ad space in sidebar?",
          "id"    => "banner_sidebar_enable",
          "std"   => "off",
          "type"  => "checkbox"),

	array("name"  => "Ad Position",
          "desc"  => "Do you want to place the banner before the widgets or after the widgets?",
          "id"    => "banner_sidebar_position",
          "options" => array('Before widgets', 'After widgets'),
          "std"   => "Before widgets",
          "type"  => "select"),

    array("name"  => "HTML Code (Adsense)",
          "desc"  => "Enter complete HTML code for your banner (or Adsense code) or upload an image below.",
          "id"    => "banner_sidebar_html",
          "std"   => "",
          "type"  => "textarea"),

	array("name"  => "Upload your image",
          "desc"  => "Upload a banner image or enter the URL of an existing image.<br/>Recommended size: <strong>300 × 250px</strong>",
          "id"    => "banner_sidebar",
          "std"   => "",
          "type"  => "upload"),

	array("name"  => "Destination URL",
          "desc"  => "Enter the URL where this banner ad points to.",
          "id"    => "banner_sidebar_url",
          "type"  => "text"),

	array("name"  => "Banner Title",
          "desc"  => "Enter the title for this banner which will be used for ALT tag.",
          "id"    => "banner_sidebar_alt",
          "type"  => "text"),



)


/* end return */);