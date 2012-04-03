<?php

// A message to translators: Aeva Media merges Aeva and SMF Media Gallery, and thus
// you should take Aeva's Aeva.yourlanguage.php and merge it with MGallery.yourlanguage.php.
// Hopefully you can work it out with your fellow translator if you didn't do both in
// the first place. Or just re-translate Aeva if you did SMG -- it's not too much work.
// Also, don't be scared by the fact that all lines were changed. You simply need to
// do a search on the term "$txt['mgallery_" and replace it with "$txt['aeva_". This
// can be made in ten seconds, and there are no conflicts with existing "aeva_" items.
// You will also need to replace permissionname_mgallery with permissionname_aeva,
// and replace every occurrence of 'general' in the variable names to 'featured'.

global $txt, $scripturl;

// Auto-embedder strings
$txt['aeva'] = 'Aeva';
//$txt['aeva_title'] = 'Aeva (Auto-Embed Video &amp; Audio)';
//$txt['aeva_admin_aeva'] = 'Aeva Administration - Settings';
//$txt['aeva_admin_aevasites'] = 'Aeva Administration - Site List';
$txt['aeva_enable'] = 'Enable Aeva mod (Master Setting)';
$txt['aeva_lookups'] = 'Enable Lookups';
$txt['aeva_lookup_success'] = 'This feature WILL work on your server';
$txt['aeva_lookup_fail'] = 'This feature will NOT work on your server';
$txt['aeva_max_per_post'] = 'Max Embedding Per Post';
$txt['aeva_max_per_page'] = 'Max Embedding Per Page';
$txt['aeva_max_warning'] = 'Too much Flash is bad for your browser\'s health';
$txt['aeva_quotes'] = 'Enable Embedding in Quotes';
$txt['aeva_mov'] = 'MOV Files (via Quicktime)';
$txt['aeva_real'] = 'RAM/RM Files (via Real Media)';
$txt['aeva_wmp'] = 'WMV/WMA Files (via Windows Media)';
$txt['aeva_swf'] = 'SWF Flash animations';
$txt['aeva_flv'] = 'FLV Flash videos';
$txt['aeva_divx'] = 'DivX files (.divx)';
$txt['aeva_avi'] = 'AVI files (via DivX player)';
$txt['aeva_mp3'] = 'MP3 files (via Flash player)';
$txt['aeva_mp4'] = 'MP4 files (via Flash player)';
$txt['aeva_ext'] = 'Allowed file extensions';
$txt['aeva_fix_html'] = 'Fix uses of the embed HTML with an embeddable link';
$txt['aeva_noexternalembedding'] = '(The video\'s owner prevents external embedding)';
$txt['aeva_includeurl'] = 'Include the Original Link';
$txt['aeva_includeurl_desc'] = '(for sites that don\'t have it in the player)';
$txt['aeva_debug'] = 'Aeva Debug Mode (Admin Only)';
$txt['aeva_debug_took'] = 'Aeva Debug:';
$txt['aeva_debug_seconds'] = ' seconds.';
$txt['aeva_debug_desc'] = 'Time taken to auto embed is appended to each post.';
$txt['aeva_local'] = 'Embed Local Files [Excludes attachments]';
$txt['aeva_local_desc'] = 'Local means on the same server. But this doesn\'t allow ANY file of this type to be embedded from anywhere.';
$txt['aeva_denotes'] = '(Sites marked with * require lookups)';
$txt['aeva_fish'] = '(Sites marked with * require lookups, however lookups will NOT work on your server.<br /> Therefore unless you manually fish for an embeddable url yourself, embedding will NOT work for these sites.)';
$txt['aeva_pop_sites'] = 'Popular Sites';
$txt['aeva_video_sites'] = 'Video Sites';
$txt['aeva_audio_sites'] = 'Audio Sites';
$txt['aeva_other_sites'] = 'Other Sites';
$txt['aeva_adult_sites'] = 'Adult Sites';
$txt['aeva_custom_sites'] = 'Custom Sites';
$txt['aeva_select'] = 'Select All';
$txt['aeva_reset'] = 'Reset To Defaults';
$txt['aeva_disable'] = 'Disable Embedding';
$txt['aeva_sites'] = 'Sitelist';
$txt['aeva_titles'] = 'Store &amp; show video titles';
$txt['aeva_titles_desc'] = '(if site is supported by Aeva)';
$txt['aeva_titles_yes'] = 'Yes, lookup and show';
$txt['aeva_titles_yes2'] = 'Yes, but don\'t store anything new';
$txt['aeva_titles_no'] = 'No, but keep looking them up for later';
$txt['aeva_titles_no2'] = 'No, don\'t store and don\'t show';
$txt['aeva_inlinetitles'] = 'Show title inside video thumbnails';
$txt['aeva_inlinetitles_desc'] = '(for supported sites, such as YouTube and Vimeo)';
$txt['aeva_inlinetitles_yes'] = 'Yes';
$txt['aeva_inlinetitles_maybe'] = 'Only if the title isn\'t already stored';
$txt['aeva_inlinetitles_no'] = 'No';
$txt['aeva_noscript'] = 'Use earlier, Javascript-less, embedding system';
$txt['aeva_noscript_desc'] = 'Only use if you have compatibility issues';
$txt['aeva_expins'] = 'Show Flash express installer';
$txt['aeva_expins_desc'] = 'If the user\'s Flash version is outdated, movies will offer to upgrade it';
$txt['aeva_lookups_desc'] = 'Most of Aeva\'s features require a lookup';
$txt['aeva_center'] = 'Center videos horizontally';
$txt['aeva_center_desc'] = 'Or add "-center" to any video\'s anchor settings (e.g. #ws-center)';
$txt['aeva_lookup_titles'] = 'Try to find titles in all sites';
$txt['aeva_lookup_titles_desc'] = '(even when they\'re not supported - you never know)';
$txt['aeva_incontext'] = 'Enable Embedding in Sentences';
$txt['aeva_too_many_embeds'] = '(Embedding disabled, limit reached)';
$txt['aeva_nonlocal'] = 'Accept external websites in addition to local embeds';
$txt['aeva_nonlocal_desc'] = 'In case it isn\'t clear: this isn\'t a recommended setting, at least security-wise.';
$txt['aeva_max_width'] = 'Maximum width for embedded videos';
$txt['aeva_max_width_desc'] = 'Leave empty to disable. Enter 600 for a maximum width of 600 pixels. Larger videos will be resized, while smaller videos will add a link to let you resize them to the maximum width.';
$txt['aeva_yq'] = 'Default YouTube quality';
$txt['aeva_yq_default'] = 'Default';
$txt['aeva_yq_hd'] = 'HD where available';
$txt['aeva_small'] = 'Small';
$txt['aeva_large'] = 'Large';

// General tabs and titles
$txt['aeva_title'] = 'Aeva Media';
$txt['aeva_admin'] = 'Admin';
$txt['aeva_add_title'] = 'Title';
$txt['aeva_add_desc'] = 'Description';
$txt['aeva_add_file'] = 'File to upload';
$txt['aeva_add_allowedTypes'] = 'Allowed File types';
$txt['aeva_add_embed'] = '<i><u>Or</u></i> Embed URL (remote videos)';
$txt['aeva_add_keywords'] = 'Keywords';
$txt['aeva_width'] = 'Width';
$txt['aeva_height'] = 'Height';
$txt['aeva_albums'] = 'Albums';
$txt['aeva_icon'] = 'Icon';
$txt['aeva_name'] = 'Name';
$txt['aeva_item'] = 'Item';
$txt['aeva_items'] = 'Items';
$txt['aeva_lower_item'] = 'item';
$txt['aeva_lower_items'] = 'items';
$txt['aeva_files'] = 'Files';
$txt['aeva_submissions'] = 'Submissions';
$txt['aeva_started_on'] = 'Started On';
$txt['aeva_recent_items'] = 'Recent Items';
$txt['aeva_random_items'] = 'Random Items';
$txt['aeva_recent_comments'] = 'Recent Comments';
$txt['aeva_recent_albums'] = 'Latest Albums';
$txt['aeva_views'] = 'Views';
$txt['aeva_downloads'] = 'Downloads';
$txt['aeva_posted_by'] = 'Posted by';
$txt['aeva_posted_on_date'] = 'Posted on'; // For use in 'Posted on March 21'
$txt['aeva_posted_on'] = 'Posted'; // For use in 'Posted Today/Yesterday'
$txt['aeva_in_album'] = 'in';
$txt['aeva_comment_in'] = 'In';
$txt['aeva_on_date'] = 'on';
$txt['aeva_short_date_format'] = '%b %d, %Y';
$txt['aeva_today'] = '<b>Today</b>';
$txt['aeva_yesterday'] = '<b>Yesterday</b>';
$txt['aeva_by'] = 'By';
$txt['aeva_on'] = 'On';
$txt['aeva_bytes'] = 'bytes';
$txt['aeva_kb'] = 'KB';
$txt['aeva_mb'] = 'MB';
$txt['aeva_time'] = 'Time';
$txt['aeva_date'] = 'Date';
$txt['aeva_unapproved_items'] = 'Unapproved Items';
$txt['aeva_unapproved_comments'] = 'Unapproved Comments';
$txt['aeva_unapproved_albums'] = 'Unapproved Albums';
$txt['aeva_unapproved_item_edits'] = 'Unapproved Item Edits';
$txt['aeva_unapproved_album_edits'] = 'Unapproved Album Edits';
$txt['aeva_reported_items'] = 'Reported Items';
$txt['aeva_reported_comments'] = 'Reported Comments';
$txt['aeva_submit'] = 'Submit';
$txt['aeva_sub_albums'] = 'Sub Albums';
$txt['aeva_max_file_size'] = 'Maximum File Size Allowed';
$txt['aeva_stats'] = 'Statistics';
$txt['aeva_featured_album'] = 'Featured Album';
$txt['aeva_album_type'] = 'Album Type';
$txt['aeva_album_name'] = 'Album Name';
$txt['aeva_album_desc'] = 'Album Description';
$txt['aeva_add_item'] = 'Add an item to this album';
$txt['aeva_sort_by'] = 'Sort by';
$txt['aeva_sort_by_0'] = 'ID';
$txt['aeva_sort_by_1'] = 'Date';
$txt['aeva_sort_by_2'] = 'Title';
$txt['aeva_sort_by_3'] = 'Views';
$txt['aeva_sort_by_4'] = 'Rating';
$txt['aeva_sort_order'] = 'Sort Order';
$txt['aeva_sort_order_asc'] = 'Ascending';
$txt['aeva_sort_order_desc'] = 'Descending';
$txt['aeva_sort_order_filename'] = 'File name';
$txt['aeva_sort_order_filesize'] = 'File size';
$txt['aeva_sort_order_filedate'] = 'File date';
$txt['aeva_pages'] = 'Pages';
$txt['aeva_thumbnail'] = 'Thumbnail';
$txt['aeva_item_title'] = 'Title';
$txt['aeva_item_desc'] = 'Description';
$txt['aeva_filesize'] = 'Filesize';
$txt['aeva_keywords'] = 'Keywords';
$txt['aeva_rating'] = 'Rating';
$txt['aeva_rate_it'] = 'Rate it!';
$txt['aeva_item_info'] = 'Item Info';
$txt['aeva_comments'] = 'Comments';
$txt['aeva_comment'] = 'Comment';
$txt['aeva_sort_order_com'] = 'Sorting comments by date';
$txt['aeva_comment_this_item'] = 'Comment';
$txt['aeva_report_this_item'] = 'Report';
$txt['aeva_edit_this_item'] = 'Edit';
$txt['aeva_delete_this_item'] = 'Delete';
$txt['aeva_download_this_item'] = 'Download';
$txt['aeva_move_item'] = 'Move';
$txt['aeva_commenting_this_item'] = 'Comment on this item';
$txt['aeva_reporting_this_item'] = 'Report this item';
$txt['aeva_moving_this_item'] = 'Move this item';
$txt['aeva_commenting'] = 'Comment';
$txt['aeva_message'] = 'Message';
$txt['aeva_reporting'] = 'Report item';
$txt['aeva_reason'] = 'Reason';
$txt['aeva_add'] = 'Add item';
$txt['aeva_last_edited'] = 'Last Edited';
$txt['aeva_album'] = 'Album';
$txt['aeva_album_to_move'] = 'Album to move to';
$txt['aeva_moving'] = 'Moving';
$txt['aeva_viewing_unseen'] = 'Unseen items';
$txt['aeva_search_for'] = 'Search for';
$txt['aeva_search_in_title'] = 'Search in title';
$txt['aeva_search_in_description'] = 'Search in description';
$txt['aeva_search_in_kw'] = 'Search in keywords';
$txt['aeva_search_in_album_name'] = 'Search in album names';
$txt['aeva_search_in_album'] = 'Search in album';
$txt['aeva_search_in_all_albums'] = 'Search in all albums';
$txt['aeva_search_by_mem'] = 'Search items by member';
$txt['aeva_search_in_cf'] = 'Search in %s';
$txt['aeva_search'] = 'Search';
$txt['aeva_owner'] = 'Owner';
$txt['aeva_my_user_albums'] = 'My&nbsp;Albums';
$txt['aeva_yes'] = 'Yes';
$txt['aeva_no'] = 'No';
$txt['aeva_extra_info'] = 'Exif Metadata';
$txt['aeva_poster_info'] = 'Poster information';
$txt['aeva_gen_stats'] = 'General statistics';
$txt['aeva_total_items'] = 'Total Items';
$txt['aeva_total_albums'] = 'Total Albums';
$txt['aeva_total_comments'] = 'Total Comments';
$txt['aeva_total_featured_albums'] = 'Total Featured Albums';
$txt['aeva_avg_items'] = 'Average items per day';
$txt['aeva_avg_comments'] = 'Average comments per day';
$txt['aeva_total_item_contributors'] = 'Total Item Contributors';
$txt['aeva_total_commentators'] = 'Total Commentators';
$txt['aeva_top_uploaders'] = 'Top 5 Uploaders';
$txt['aeva_top_commentators'] = 'Top 5 Commentators';
$txt['aeva_top_albums_items'] = 'Top 5 Albums by items';
$txt['aeva_top_albums_comments'] = 'Top 5 Albums by comments';
$txt['aeva_top_items_views'] = 'Top 5 Items by views';
$txt['aeva_top_items_comments'] = 'Top 5 Items by comments';
$txt['aeva_top_items_rating'] = 'Top 5 Items by rating';
$txt['aeva_top_items_voters'] = 'Top 5 Items by voters';
$txt['aeva_filename'] = 'Filename';
$txt['aeva_aka'] = 'a.k.a.';
$txt['aeva_no_comments'] = 'No comments';
$txt['aeva_no_items'] = 'No items';
$txt['aeva_no_albums'] = 'No Albums';
$txt['aeva_no_uploaders'] = 'No uploaders';
$txt['aeva_no_commentators'] = 'No commentators';
$txt['aeva_multi_upload'] = 'Mass Upload';
$txt['aeva_selectFiles'] = 'Select files';
$txt['aeva_upload'] = 'Upload';
$txt['aeva_errors'] = 'Errors';
$txt['aeva_membergroups_guests'] = 'Guests';
$txt['aeva_membergroups_members'] = 'Regular Members';
$txt['aeva_album_mainarea'] = 'Album details';
$txt['aeva_album_privacy'] = 'Privacy';
$txt['aeva_all_albums'] = 'All albums';
$txt['aeva_show'] = 'Show';
$txt['aeva_prev'] = 'Previous';
$txt['aeva_next'] = 'Next';
$txt['aeva_embed_bbc'] = 'BBC embed code';
$txt['aeva_embed_html'] = 'HTML embed code';
$txt['aeva_direct_link'] = 'Direct link';
$txt['aeva_profile_sum_pt'] = 'Gallery Summary';
$txt['aeva_profile_sum_desc'] = 'Gallery User Summary - here you will find information on the user\'s contributions to the gallery.';
$txt['aeva_profile_stats'] = 'Gallery stats';
$txt['aeva_latest_item'] = 'Latest item';
$txt['aeva_top_albums'] = 'Top albums';
$txt['aeva_profile_viewitems'] = 'Gallery - View items';
$txt['aeva_profile_viewcoms'] = 'Gallery - View comments';
$txt['aeva_profile_viewvotes'] = 'Gallery - View votes';
$txt['aeva_profile_viewitems_pt'] = 'View items';
$txt['aeva_profile_viewcoms_pt'] = 'View comments';
$txt['aeva_profile_viewvotes_pt'] = 'View votes';
$txt['aeva_profile_viewitems_desc'] = 'View all the items posted by the user. Please note that this will only list items from albums which you can access.';
$txt['aeva_profile_viewcoms_desc'] = 'View all the comments posted by the user. Please note that this will only list comments from albums which you can access.';
$txt['aeva_profile_viewvotes_desc'] = 'View all the ratings given by the user. Please note that this will only list votes from albums which you can access.';
$txt['aeva_version'] = 'Installed version';
$txt['aeva_switch_fulledit'] = 'Switch to full edit page with smileys and BBCode';
$txt['aeva_needs_js_flash'] = 'Please note that this feature will not work if you disabled Javascript or Flash support in your browser.';
$txt['aeva_action'] = 'Action';
$txt['aeva_member'] = 'Member';
$txt['aeva_approve_this'] = 'This item is currently waiting for approval.';
$txt['aeva_use_as_album_icon'] = 'Use this item\'s thumbnail as the album icon.';
$txt['aeva_default_sort_order'] = 'Default sort order';
$txt['aeva_overall_prog'] = 'Overall progress';
$txt['aeva_curr_prog'] = 'Current file progress';
$txt['aeva_add_desc_subtxt'] = 'You may use BBCode here, and say anything you\'d like. Please don\'t say anything boring, though. Like this description. People don\'t like that.';
$txt['aeva_mark_as_seen'] = 'Mark all as seen';
$txt['aeva_mark_album_as_seen'] = 'Mark as seen';
$txt['aeva_search_results_for'] = 'results found for';
$txt['aeva_toggle_all'] = 'Toggle all';
$txt['aeva_weighted_mean'] = 'Weighted average';
$txt['aeva_passwd_locked'] = 'Password-protected album - Requires a password';
$txt['aeva_passwd_unlocked'] = 'Password-protected album - Unlocked for you';
$txt['aeva_who_rated_what'] = 'Who rated what?';
$txt['aeva_max_thumbs_reached'] = '[Limit reached]';
$txt['aeva_filetype_im'] = 'Image files';
$txt['aeva_filetype_au'] = 'Audio files';
$txt['aeva_filetype_vi'] = 'Video files';
$txt['aeva_filetype_do'] = 'Documents';
$txt['aeva_filetype_zi'] = 'Multimedia archives';
$txt['aeva_entities_always'] = 'Always convert (recommended)';
$txt['aeva_entities_no_utf'] = 'Always convert, except when in UTF-8 mode';
$txt['aeva_entities_never'] = 'Never convert';
$txt['aeva_prevnext_small'] = 'Show 3 thumbnails, including the current one';
$txt['aeva_prevnext_big'] = 'Show 5 thumbnails, including the current one';
$txt['aeva_prevnext_text'] = 'Only show text links';
$txt['aeva_prevnext_none'] = 'Don\'t show anything';
$txt['aeva_default_tag_normal'] = 'Show thumbnails (smaller size)';
$txt['aeva_default_tag_preview'] = 'Show previews (intermediate size)';
$txt['aeva_default_tag_full'] = 'Show full picture';
$txt['aeva_force_thumbnail'] = 'Use this file as thumbnail';
$txt['aeva_force_thumbnail_subtxt'] = 'If you\'re sending a local file that won\'t generate its own thumbnail... Think of a CD cover for a MP3, or a screenshot for a video...';
$txt['aeva_force_thumbnail_edit'] = ' Leave empty to keep current thumbnail, if any.';
$txt['aeva_default_perm_profile'] = 'Default profile';
$txt['aeva_perm_profile'] = 'Permission profile';
$txt['aeva_image'] = 'Image Files';
$txt['aeva_video'] = 'Video Files';
$txt['aeva_audio'] = 'Audio Files';
$txt['aeva_doc'] = 'Documents';
$txt['aeva_type_image'] = 'Image';
$txt['aeva_type_video'] = 'Video';
$txt['aeva_type_audio'] = 'Audio File';
$txt['aeva_type_embed'] = 'Embedded Media';
$txt['aeva_type_doc'] = 'Document';
$txt['aeva_multi_download'] = 'Mass Download';
$txt['aeva_multi_download_desc'] = 'Here you can download multiple files as a ZIP archive. Please select the items that you wish to download';
$txt['aeva_album_is_hidden'] = 'This album can only be browsed by its owner (you) and administrators. Authorized membergroups can view items if you provide them with direct links to their individual pages.';
$txt['aeva_items_view'] = 'Items view';
$txt['aeva_view_normal'] = 'Normal view';
$txt['aeva_view_filestack'] = 'Filestack view';
$txt['aeva_post_noun'] = 'post';
$txt['aeva_posts_noun'] = 'posts';
$txt['aeva_vote_noun'] = 'vote';
$txt['aeva_votes_noun'] = 'votes';
$txt['aeva_voter_list'] = 'Members who rated at least one item';
$txt['aeva_pixels'] = 'pixels';
$txt['aeva_more_albums_left'] = 'and %d more albums';
$txt['aeva_items_only_in_children'] = ' in sub-albums';
$txt['aeva_items_also_in_children'] = ', and %d in sub-albums';
$txt['aeva_unbrowsable'] = 'Browsing disabled';
$txt['aeva_access_read'] = 'Read';
$txt['aeva_access_write'] = 'Write';
$txt['aeva_default_welcome'] = 'Welcome to the gallery section, powered by Aeva Media. To delete or modify this welcome message, just edit file /Themes/default/languages/Modifications.english.php and add this line to it:<br /><pre>$txt[\'aeva_welcome\'] = \'Welcome.\';</pre>You can also change the text directly from within the admin area. This is simpler but you lose the ability to translate it to multiple languages.';
$txt['aeva_mass_cancel'] = 'Cancel';
$txt['aeva_file_too_large_php'] = 'This file is too large for the server to handle. It has been discarded, because it would stall the server otherwise. The maximum allowed size for an upload, according to the php.ini file, is %s MB.';
$txt['aeva_file_too_large_quota'] = 'This file is too large for your allowed quota. It has been discarded, as uploading it would fail anyway.';
$txt['aeva_file_too_large_img'] = 'This file is too large for your allowed quota. You can cancel its upload, or try uploading it, as it is an image and may be successfully resized to smaller dimensions.';
$txt['aeva_user_deleted'] = '(Deleted User)';
$txt['aeva_silent_update'] = 'Silent update';
$txt['aeva_close'] = 'Close';
$txt['aeva_page_seen'] = 'Mark page as seen';

// Aeva Media's Foxy! add-on strings
$txt['aeva_linked_topic'] = 'Linked topic';
$txt['aeva_linked_topic_board'] = 'Create a linked topic in...';
$txt['aeva_no_topic_board'] = 'Don\'t create a linked topic';
$txt['aeva_topic'] = 'Album';
$txt['aeva_tag_no_items'] = '(No items to show)';
$txt['aeva_playlist'] = 'Playlist';
$txt['aeva_playlists'] = 'Playlists';
$txt['aeva_my_playlists'] = 'My Playlists';
$txt['aeva_related_playlists'] = 'Related playlists';
$txt['aeva_items_from_album'] = '%1$d items from one album';
$txt['aeva_items_from_albums'] = '%1$d items from %2$d albums';
$txt['aeva_from_album'] = 'from one album';
$txt['aeva_from_albums'] = 'from %1$d albums';
$txt['aeva_new_playlist'] = 'New Playlist';
$txt['aeva_add_to_playlist'] = 'Add to a playlist';
$txt['aeva_playlist_done'] = 'Operation completed successfully.';
$txt['aeva_and'] = 'and';
$txt['aeva_foxy_stats_video'] = 'video';
$txt['aeva_foxy_stats_videos'] = 'videos';
$txt['aeva_foxy_stats_audio'] = 'audio file';
$txt['aeva_foxy_stats_audios'] = 'audio files';
$txt['aeva_foxy_stats_image'] = 'image';
$txt['aeva_foxy_stats_images'] = 'images';
$txt['aeva_foxy_audio_list'] = 'Audio list';
$txt['aeva_foxy_video_list'] = 'Video list';
$txt['aeva_foxy_image_list'] = 'Image list';
$txt['aeva_foxy_media_list'] = 'Multimedia list';
$txt['aeva_foxy_add_tag'] = 'Click <a href="%1$s">here</a> to insert the tag into your message and close this window. (Experimental!)';
$txt['aeva_foxy_and_children'] = 'and sub-albums';

// Lightbox strings
$txt['aeva_lightbox_section'] = 'Highslide (Animated transitions)';
$txt['aeva_lightbox_enable'] = 'Enable Highslide';
$txt['aeva_lightbox_enable_info'] = 'Highslide is a lightbox-type script designed to show an animated transition when you click on a picture thumbnail.';
$txt['aeva_lightbox_outline'] = 'Outline shadow';
$txt['aeva_lightbox_outline_info'] = 'Defines the type of outline to display around the expanded content. <i>drop-shadow</i> is a simple drop shadow, while <i>rounded-white</i> adds a white border with rounded corners and a smaller drop shadow.';
$txt['aeva_lightbox_expand'] = 'Duration of animation';
$txt['aeva_lightbox_expand_info'] = '<i>In milliseconds</i>. Defines how long the zoom effect should take.';
$txt['aeva_lightbox_autosize'] = 'Scale to browser window';
$txt['aeva_lightbox_autosize_info'] = 'Allow larger pictures to shrink to fit the browser window. Clicking on the Expand icon will restore them to full size.';
$txt['aeva_lightbox_fadeinout'] = 'Fade in/out';
$txt['aeva_lightbox_fadeinout_info'] = 'Add a fading effect to the animation.';

// Highslide Javascript strings.
// Escape single quotes twice (\\\' instead of \') otherwise it won't work.
$txt['aeva_hs_close_title'] = 'Close (Esc)';
$txt['aeva_hs_move'] = 'Move';
$txt['aeva_hs_loading'] = 'Loading...';
$txt['aeva_hs_clicktocancel'] = 'Click to cancel';
$txt['aeva_hs_clicktoclose'] = 'Click to close image, drag to move';
$txt['aeva_hs_expandtoactual'] = 'Expand to actual size (f)';
$txt['aeva_hs_focus'] = 'Click to bring to front';
$txt['aeva_hs_previous'] = 'Previous (left arrow)';
$txt['aeva_hs_next'] = 'Next (right arrow)';
$txt['aeva_hs_play'] = 'Play slideshow (spacebar)';
$txt['aeva_hs_pause'] = 'Pause slideshow (spacebar)';

// Help strings
$txt['aeva_add_keywords_sub'] = 'Use comma (,) as a separator';
$txt['aeva_add_embed_sub'] = 'URL to embed video from (e.g. Youtube.) Enter only if you are not uploading a file.';
$txt['aeva_will_be_approved'] = 'Your submission will be reviewed by a moderator before being made public.';
$txt['aeva_com_will_be_approved'] = 'Your comment will first have to be approved by a moderator before it can be read.';
$txt['aeva_album_will_be_approved'] = 'Your album will first have to be approved by a moderator before it is activated.';
$txt['aeva_what_album'] = 'This item will be added to album <a href="%s">%s</a>';
$txt['aeva_what_album_select'] = 'Select which album you want to upload this item to';
$txt['aeva_no_listing'] = 'There are no items to list';
$txt['aeva_resized'] = 'Click the picture to view full size.';
// Escape single quotes twice (\\\' instead of \') for aeva_confirm, otherwise it won't work.
$txt['aeva_confirm'] = 'Are you sure you want to do this?';
$txt['aeva_reported'] = 'This item has been reported and will be reviewed by an administrator.<br /><br /><a href="%s">Return</a>';
$txt['aeva_edit_file_subtext'] = 'Leave this blank if you do not wish do re-upload a file. Please remember that, if you upload a file, the old one will be replaced by the new one';
$txt['aeva_embed_sub_edit'] = 'Change your embed URL. If you do this, any previous URLs and related files will be overwritten.';
$txt['aeva_editing_item'] = 'You are editing item <a href="%s">%s</a>';
$txt['aeva_editing_com'] = 'Editing Comment';
$txt['aeva_moving_item'] = 'Moving item';
$txt['aeva_search_by_mem_sub'] = 'Use comma (,) as a separator. Leave blank to search items by all members. Enter a member\'s username';
$txt['aeva_passwd_protected'] = 'This album is password protected, please enter the password to continue.';
$txt['aeva_user_albums_desc'] = 'You can manage your albums here, adding new albums or editing existing ones.';
$txt['aeva_click_to_close'] = 'Click to close';
$txt['aeva_multi_dl_wait'] = 'The script is taking a short break to avoid server overload. %s of %s done';
$txt['aeva_too_many_items'] = 'There were too many items, please reduce the number of items';

// Errors
$txt['aeva_albumSwitchError'] = 'One or more albums are using the profile you\'re trying to delete. Please select a profile to switch them to before you proceed.';
$txt['aeva_accessDenied'] = 'Sorry, but you are not allowed to access the gallery';
$txt['aeva_add_not_allowed'] = 'Sorry, but you do not have permission to upload this type of item to this gallery';
$txt['aeva_add_album_not_set'] = 'Album is not set';
$txt['aeva_album_denied'] = 'Access to this album is denied';
$txt['aeva_file_not_specified'] = 'You haven\'t specified a file to upload. Or maybe you tried to upload a file too large for the server to handle?';
$txt['aeva_title_not_specified'] = 'Title is not specified';
$txt['aeva_invalid_extension'] = 'The file has a invalid extension (%s)';
$txt['aeva_upload_file_too_big'] = 'The file size is larger (%s KB) than the system allows';
$txt['aeva_upload_dir_not_writable'] = 'Upload directory is not writable';
$txt['aeva_upload_failed'] = 'An error happened during the upload process, please try again or contact the administrator.<br />%s';
$txt['aeva_error_height'] = 'The image\'s height (%s pixels) is more than allowed';
$txt['aeva_error_width'] = 'The image\'s width (%s pixels) is more than allowed';
$txt['aeva_invalid_embed_link'] = 'The embed URL was either bad or from an unsupported site. If you\'re trying to embed a picture, make sure the Foxy! add-on for Aeva Media is installed.';
$txt['aeva_banned_full'] = 'You are banned from accessing the gallery';
$txt['aeva_banned_post'] = 'You are banned from posting items';
$txt['aeva_banned_comment_post'] = 'You are banned from posting comments';
$txt['aeva_item_not_found'] = 'The item you specified was not found';
$txt['aeva_item_access_denied'] = 'You are not allowed to access this item';
$txt['aeva_invalid_rating'] = 'The rating is invalid';
$txt['aeva_rate_denied'] = 'You are not allowed to rate items';
$txt['aeva_re-rating_denied'] = 'You are not allowed to re-rate an item';
$txt['aeva_comment_not_allowed'] = 'You are not allowed to comment items';
$txt['aeva_comment_left_empty'] = 'Comment was left empty';
$txt['aeva_com_report_denied'] = 'You are not allowed to report comments';
$txt['aeva_report_left_empty'] = 'Reason was left empty';
$txt['aeva_item_report_denied'] = 'You are not allowed to report items';
$txt['aeva_edit_denied'] = 'You are not allowed to edit this item';
$txt['aeva_com_not_found'] = 'Comment was not found';
$txt['aeva_delete_denied'] = 'You are not allowed to delete items';
$txt['aeva_move_denied'] = 'You are not allowed to move items';
$txt['aeva_invalid_album'] = 'You have submitted to a invalid album';
$txt['aeva_filemove_failed'] = 'A problem occurred while moving files.';
$txt['aeva_search_left_empty'] = 'Search keyword was left empty';
$txt['aeva_no_search_option_selected'] = 'No search option selected';
$txt['aeva_search_mem_not_found'] = 'No members match your search';
$txt['aeva_search_denied'] = 'You are not allowed to search for items in the gallery';
$txt['aeva_album_not_found'] = 'Album not found';
$txt['aeva_unseen_denied'] = 'You are not allowed to use the Unseen Items feature.';
$txt['aeva_dest_failed'] = 'Cannot find proper destination on the server, please contact your administrator';
$txt['aeva_not_a_dir'] = 'This copy of Aeva Media has an incorrect path set for the data folder. If you are the admin, make sure it is updated in your settings. Otherwise, contact them and have a good laugh. But not too much, it would be cruel.';
$txt['aeva_size_mismatch'] = 'This item\'s filesize doesn\'t match the size that was recorded when uploading it. Ask the administrator whether they manually re-uploaded the file by FTP. If yes, tell them to retry, only this time in <i>binary</i> mode, not <i>ASCII</i> or <i>auto</i>...';

// Admin general strings
$txt['aeva_admin_labels_index'] = 'Index';
$txt['aeva_admin_labels_settings'] = 'Settings';
$txt['aeva_admin_labels_embed'] = 'Auto-Embedding';
$txt['aeva_admin_labels_reports'] = 'Reports';
$txt['aeva_admin_labels_submissions'] = 'Submissions';
$txt['aeva_admin_labels_bans'] = 'Bans';
$txt['aeva_admin_labels_albums'] = 'Albums';
$txt['aeva_admin_labels_maintenance'] = 'Maintenance';
$txt['aeva_admin_labels_about'] = 'About';
$txt['aeva_admin_labels_ftp'] = 'FTP Import';
$txt['aeva_admin_labels_perms'] = 'Permission Profiles';
$txt['aeva_admin_labels_quotas'] = 'Quota Profiles';
$txt['aeva_admin_settings_config'] = 'Configuration';
$txt['aeva_admin_settings_title_main'] = 'Main settings';
$txt['aeva_admin_settings_title_security'] = 'Security settings';
$txt['aeva_admin_settings_title_limits'] = 'Limits';
$txt['aeva_admin_settings_title_tag'] = 'Embed code and [smg] tags';
$txt['aeva_admin_settings_title_misc'] = 'Miscellaneous';
$txt['aeva_admin_settings_welcome'] = 'Welcome message';
$txt['aeva_admin_settings_welcome_subtext'] = 'Leave empty to use $txt[\'aeva_welcome\'] in the Modifications.english.php file (which you can set in multiple languages), or the default welcome message.';
$txt['aeva_admin_settings_data_dir_path'] = 'Data directory path';
$txt['aeva_admin_settings_data_dir_path_subtext'] = 'Server path (e.g. /home/www/mgal_data)';
$txt['aeva_admin_settings_data_dir_url'] = 'Data directory URL';
$txt['aeva_admin_settings_data_dir_url_subtext'] = 'Same path, but through a web browser (e.g. http://mysite.com/mgal_data)';
$txt['aeva_admin_settings_max_dir_files'] = 'Max number of files in a directory';
$txt['aeva_admin_settings_max_dir_size'] = 'Max size of a directory';
$txt['aeva_admin_settings_enable_re-rating'] = 'Enable Re-Rating';
$txt['aeva_admin_settings_use_exif_date'] = 'Use Exif datetime for upload date if available';
$txt['aeva_admin_settings_use_exif_date_subtext'] = 'If the file has Exif data available, the upload date will use its datetime setting instead of the current time.';
$txt['aeva_admin_settings_title_files'] = 'File settings';
$txt['aeva_admin_settings_title_previews'] = 'Preview size settings';
$txt['aeva_admin_settings_max_file_size'] = 'Max file size';
$txt['aeva_admin_settings_max_file_size_subtext'] = 'Set to 0 and use the Quotas section to finetune.';
$txt['aeva_admin_settings_max_width'] = 'Max width';
$txt['aeva_admin_settings_max_height'] = 'Max height';
$txt['aeva_admin_settings_allow_over_max'] = 'Allow resizing of large pictures';
$txt['aeva_admin_settings_allow_over_max_subtext'] = 'If uploaded pictures are over the max width or height, the server will attempt to resize them to match the max size specifications. Not recommended on overloaded servers. Select &quot;No&quot; to reject such pictures.';
$txt['aeva_admin_settings_upload_security_check'] = 'Enable security check at upload time';
$txt['aeva_admin_settings_upload_security_check_subtext'] = 'Prevents users from uploading malicious files, but may also rarely reject some healthy files. It isn\'t recommended to enable this, unless you have some really, really stupid IE users looking for trouble.';
$txt['aeva_admin_settings_log_access_errors'] = 'Log access errors';
$txt['aeva_admin_settings_log_access_errors_subtext'] = 'If enabled, all <em>Access denied</em> errors within Aeva Media will show up in your general error log.';
$txt['aeva_admin_settings_ftp_file'] = 'File path to the Safe Mode file';
$txt['aeva_admin_settings_ftp_file_subtext'] = 'Read the MGallerySafeMode.php for more details. Required if your server has Safe Mode enabled!';
$txt['aeva_admin_settings_jpeg_compression'] = 'Jpeg Compression';
$txt['aeva_admin_settings_jpeg_compression_subtext'] = 'Determines the quality of resized pictures, including previews and thumbnails. Choose between 0 (bad quality, small file) and 100 (high quality, large file). The default value (80) is recommended. Values between 65 and 85 are the best compromise.';
$txt['aeva_admin_settings_exif'] = 'Exif';
$txt['aeva_admin_settings_layout'] = 'Layout';
$txt['aeva_admin_settings_show_extra_info'] = 'Show Exif data';
$txt['aeva_admin_settings_show_info'] = 'Exif metadata to show';
$txt['aeva_admin_settings_show_info_subtext'] = 'Pictures taken by digital devices often embed useful information, such as the day the picture was taken. Here you can choose what information you want to show or not.';
$txt['aeva_admin_settings_num_items_per_page'] = 'Max items per page';
$txt['aeva_admin_settings_max_thumbs_per_page'] = 'Max [smg] tags per page';
$txt['aeva_admin_settings_max_thumbs_per_page_subtext'] = 'Maximum number of [smg] tags that will get processed on a page (they will get converted to thumbnails).';
$txt['aeva_admin_settings_recent_item_limit'] = 'Recent items limit';
$txt['aeva_admin_settings_random_item_limit'] = 'Random items limit';
$txt['aeva_admin_settings_recent_comments_limit'] = 'Recent comments limit';
$txt['aeva_admin_settings_recent_albums_limit'] = 'Recent albums limit';
$txt['aeva_admin_settings_max_thumb_width'] = 'Max thumbnail width';
$txt['aeva_admin_settings_max_thumb_height'] = 'Max thumbnail height';
$txt['aeva_admin_settings_max_preview_width'] = 'Max preview width';
$txt['aeva_admin_settings_max_preview_width_subtext'] = 'The preview is a clickable picture that is displayed on the full-size picture\'s page, to speed up loading. Set to 0 to disable. <b>Warning</b>: if disabled, large pictures might break your template layout.';
$txt['aeva_admin_settings_max_preview_height'] = 'Max preview height';
$txt['aeva_admin_settings_max_preview_height_subtext'] = 'Same. If width or height is set to 0, preview images are disabled.';
$txt['aeva_admin_settings_max_bigicon_width'] = 'Max icon width';
$txt['aeva_admin_settings_max_bigicon_width_subtext'] = 'Album icons have a thumbnail (which uses the size set in the Max thumbnail size section), and a regular size, which is used only on album pages. This sets the width for a regular size album icon.';
$txt['aeva_admin_settings_max_bigicon_height'] = 'Max icon height';
$txt['aeva_admin_settings_max_bigicon_height_subtext'] = 'Same. This sets the height for a regular size album icon.';
$txt['aeva_admin_settings_max_title_length'] = 'Maximum title length';
$txt['aeva_admin_settings_max_title_length_subtext'] = 'Maximum number of characters to show for titles above thumbnails. If cut, they can still be read when hovering over the thumbnail.';
$txt['aeva_admin_settings_enable_cache'] = 'Enable cache';
$txt['aeva_admin_settings_image_handler'] = 'Image handler';
$txt['aeva_admin_settings_show_sub_albums_on_index'] = 'Show sub albums on index';
$txt['aeva_admin_settings_use_lightbox'] = 'Use Highslide (animated transitions)';
$txt['aeva_admin_settings_use_lightbox_subtext'] = 'Highslide is a Javascript module that adds drop shadows to pictures and animated transitions when clicking on previews (zoom and fade-in/out). Disable to prevent the use of HS on all albums. If enabled, album owners may still disable Highslide per-album in the album settings.';
$txt['aeva_admin_settings_album_edit_unapprove'] = 'Unapprove albums when editing them';
$txt['aeva_admin_settings_item_edit_unapprove'] = 'Unapprove items when editing them';
$txt['aeva_admin_settings_show_linking_code'] = 'Show item linking code';
$txt['aeva_admin_settings_ffmpeg_installed'] = 'FFMPEG was found on this server, its features will be used for video files. If enabled, it will be used to create thumbnails and show extra info.';
$txt['aeva_admin_settings_entities_convert'] = 'Convert UTF-8 strings to entities?';
$txt['aeva_admin_settings_entities_convert_subtext'] = 'Strings might take a bit more space in the database, but this will allow text to always be readable.';
$txt['aeva_admin_settings_prev_next'] = 'Show Previous and Next links?';
$txt['aeva_admin_settings_prev_next_subtext'] = 'Enable this feature to show text or thumbnail shortcuts to previous and next items in the current item page.';
$txt['aeva_admin_settings_default_tag_type'] = 'Default size within [smg] tags?';
$txt['aeva_admin_settings_default_tag_type_subtext'] = 'Choose the image type that should be shown by default when no type is specified on [smg id=xxx type=xxx] tags.';
$txt['aeva_admin_settings_num_items_per_line'] = 'Max items per line';
$txt['aeva_admin_settings_num_items_per_line_ext'] = 'Max items per line';
$txt['aeva_admin_settings_my_docs'] = 'Allowed Document files';
$txt['aeva_admin_settings_my_docs_subtext'] = 'You can choose the extensions allowed for uploaded Documents. Use comma as a separator (eg. "zip,pdf"). The default list of supported file types, in case you want to reset it, is: %s';
$txt['aeva_admin_settings_player_color'] = 'Audio/video player\'s front color';
$txt['aeva_admin_settings_player_color_subtext'] = 'In hexadecimal code. By default, white (FFFFFF)';
$txt['aeva_admin_settings_player_bcolor'] = 'Audio/video player\'s background color';
$txt['aeva_admin_settings_player_bcolor_subtext'] = 'In hexadecimal code. By default, black (000000)';
$txt['aeva_admin_settings_audio_player_width'] = 'Audio player\'s width';
$txt['aeva_admin_settings_audio_player_width_subtext'] = 'In pixels. By default, 400';
$txt['aeva_admin_settings_phpini_subtext'] = 'This server-side variable limits upload sizes. You can set it via a php.ini file, see details on the right';
$txt['aeva_admin_settings_clear_thumbnames'] = 'Leave thumbnail URLs in clear view';
$txt['aeva_admin_settings_clear_thumbnames_subtext'] = 'If enabled, thumbnails will be linked by their direct URL. Saves much server processing time but slightly less secure.';
$txt['aeva_admin_settings_album_columns'] = 'Max sub-albums per line';
$txt['aeva_admin_settings_album_columns_subtext'] = 'Default is 1. If you have a lot of sub-albums, you may want to set this to 2 or 3 so that more albums are shown per row.';
$txt['aeva_admin_settings_icons_only'] = 'Use icon shortcuts in item boxes';
$txt['aeva_admin_settings_icons_only_subtext'] = 'If this is enabled, item boxes, such as the ones that show lists of items in album pages, will only show icons next to relevant information, rather than full text such as <i>Posted by</i>.';

$txt['aeva_admin_add_album'] = 'New Album';
$txt['aeva_admin_filter_normal_albums'] = 'Filter regular albums';
$txt['aeva_admin_filter_featured_albums'] = 'Filter featured albums';
$txt['aeva_admin_moderation'] = 'Moderation';
$txt['aeva_admin_moving_album'] = 'Moving album';
$txt['aeva_admin_cancel_moving'] = 'Cancel moving';
$txt['aeva_admin_type'] = 'Type';
$txt['aeva_admin_edit'] = 'Edit';
$txt['aeva_admin_delete'] = 'Delete';
$txt['aeva_admin_approve'] = 'Approve';
$txt['aeva_admin_unapprove'] = 'Unapprove';
$txt['aeva_admin_before'] = 'Before';
$txt['aeva_admin_after'] = 'After';
$txt['aeva_admin_child_of'] = 'Child of';
$txt['aeva_admin_target'] = 'Target';
$txt['aeva_admin_position'] = 'Position';
$txt['aeva_admin_membergroups'] = 'Membergroups';
$txt['aeva_admin_membergroups_subtxt'] = 'Select the membergroups that should be allowed to use the album and its contents.<br />
<ul class="aevadesc">
	<li>If all <strong>primary groups</strong> (which are bolded for your convenience) are checked, all forum members will be given access, so you don\'t need to check other groups (except for Guests).</li>
	<li><strong>Read</strong> access: membergroup can view the album and its items, and use existing permissions if enabled (commenting, rating, etc.)</li>
	<li><strong>Write</strong> access: membergroup can upload items to the album.</li>
</ul>';
$txt['aeva_admin_membergroups_primary'] = 'This group is used as a primary group by one or more members.';
$txt['aeva_admin_passwd'] = 'Password';
$txt['aeva_admin_move'] = 'Move';
$txt['aeva_admin_total_submissions'] = 'Total submissions';
$txt['aeva_admin_maintenance_tasks'] = 'Maintenance Tasks';
$txt['aeva_admin_maintenance_utils'] = 'Maintenance Utilities';
$txt['aeva_admin_maintenance_regen'] = 'Regenerating thumbnails and previews';
$txt['aeva_admin_maintenance_recount'] = 'Recount totals';
$txt['aeva_admin_maintenance_recount_subtext'] = 'Recounts totals and statistics and updates them, can be used to fix incorrect stats.';
$txt['aeva_admin_maintenance_finderrors'] = 'Find errors';
$txt['aeva_admin_maintenance_finderrors_subtext'] = 'Tries to find some common errors like missing file (either from DB or physically) or incorrect id of last comment or item.';
$txt['aeva_admin_maintenance_prune'] = 'Prune';
$txt['aeva_admin_maintenance_prune_subtext'] = 'Purge items/comments based on specific parameters.';
$txt['aeva_admin_maintenance_browse'] = 'Browse Files';
$txt['aeva_admin_maintenance_browse_subtext'] = 'Browse gallery files and show the disk usage of each directory/file.';
$txt['aeva_maintenance_done'] = 'Maintenance done';
$txt['aeva_pruning'] = 'Pruning';
$txt['aeva_admin_maintenance_prune_days'] = ' Minimum number of days';
$txt['aeva_admin_maintenance_prune_last_comment_age'] = 'Last comment older than';
$txt['aeva_admin_maintenance_prune_max_coms'] = 'Comments less than';
$txt['aeva_admin_maintenance_prune_max_views'] = 'Views less than';
$txt['aeva_admin_maintenance_checkfiles'] = 'Check for extra files';
$txt['aeva_admin_maintenance_checkfiles_subtext'] = 'Checks for unused files (not found in the aeva_media table); if any are found, the system will allow removal.';
$txt['aeva_admin_maintenance_checkorphans'] = 'Check for orphan files';
$txt['aeva_admin_maintenance_checkorphans_subtext'] = 'Checks for orphan files (not found in the aeva_files table); if any are found, the system will allow removal. <strong>Warning</strong>: launching this task will render your gallery <strong>unusable</strong> until its 3 phases are completed. It can take a long time on a large gallery.';
$txt['aeva_admin_maintenance_regen_all'] = 'Regenerate thumbnails and previews';
$txt['aeva_admin_maintenance_regen_embed'] = 'Regenerate video thumbnails';
$txt['aeva_admin_maintenance_regen_thumb'] = 'Regenerate thumbnails';
$txt['aeva_admin_maintenance_regen_preview'] = 'Regenerate previews';
$txt['aeva_admin_maintenance_regen_all_subtext'] = 'This will delete and regenerate all thumbnails and previews that can be rebuilt from their original source.';
$txt['aeva_admin_maintenance_regen_embed_subtext'] = 'This will delete and regenerate all current thumbnails, but only for <b>embedded (remote)</b> items. (YouTube, etc.)';
$txt['aeva_admin_maintenance_regen_thumb_subtext'] = 'This will delete and regenerate all thumbnails that can be rebuilt from their original source.';
$txt['aeva_admin_maintenance_regen_preview_subtext'] = 'This will delete and regenerate all previews that can be rebuilt from their original source.';
$txt['aeva_admin_maintenance_operation_pending'] = 'The current task has been paused to prevent server time outs, it will automatically resume in a second. So far, %s of %s items done.';
$txt['aeva_admin_maintenance_operation_pending_raw'] = 'The current task has been paused to prevent server time outs, it will automatically resume in a second.';
$txt['aeva_admin_maintenance_operation_phase'] = 'Phase %d of %d';
$txt['aeva_admin_maintenance_all_tasks'] = 'All tasks';
$txt['aeva_admin_labels_modlog'] = 'Moderation Log';
$txt['aeva_admin_action_type'] = 'Action type';
$txt['aeva_admin_reported_item'] = 'Reported item';
$txt['aeva_admin_reported_by'] = 'Reported by';
$txt['aeva_admin_reported_on'] = 'Reported on';
$txt['aeva_admin_del_report'] = 'Delete report';
$txt['aeva_admin_del_report_item'] = 'Delete reported item';
$txt['aeva_admin_report_reason'] = 'Reported reason';
$txt['aeva_admin_banned'] = 'Banned';
$txt['aeva_admin_banned_on'] = 'Banned on';
$txt['aeva_admin_expires_on'] = 'Expires on';
$txt['aeva_never'] = 'Never';
$txt['aeva_admin_ban_type'] = 'Ban type';
$txt['aeva_admin_ban_type_1'] = 'Full';
$txt['aeva_admin_ban_type_2'] = 'Adding items';
$txt['aeva_admin_ban_type_3'] = 'Adding comments';
$txt['aeva_admin_ban_type_4'] = 'Adding items and comments';
$txt['aeva_admin_banning'] = 'User Banning';
$txt['aeva_admin_bans_add'] = 'Add ban';
$txt['aeva_unapproved_items_notice'] = 'There are %2$d unapproved item(s), <a href="%1$s">Click here to view them</a>';
$txt['aeva_unapproved_coms_notice'] = 'There are %2$d unapproved comment(s), <a href="%1$s">Click here to view them</a>';
$txt['aeva_unapproved_albums_notice'] = 'There are %2$d unapproved album(s), <a href="%1$s">Click here to view them</a>';
$txt['aeva_reported_items_notice'] = 'There are %2$d reported item(s). <a href="%1$s">Click here to view them</a>';
$txt['aeva_reported_comments_notice'] = 'There are %2$d reported comment(s). <a href="%1$s">Click here to view them</a>';
$txt['aeva_admin_modlog_approval_item'] = 'Approved item <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_ua_item'] = 'Unapproved item <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_item'] = 'Deleted item %s (was awaiting approval)';
$txt['aeva_admin_modlog_approval_com'] = 'Approved comment <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_com'] = 'Deleted comment from item %s (was awaiting approval)';
$txt['aeva_admin_modlog_approval_album'] = 'Approved album <a href="%s">%s</a>';
$txt['aeva_admin_modlog_approval_del_album'] = 'Deleted album %s (was awaiting approval)';
$txt['aeva_admin_modlog_delete_item'] = 'Deleted item %s';
$txt['aeva_admin_modlog_delete_album'] = 'Deleted album %s';
$txt['aeva_admin_modlog_delete_comment'] = 'Deleted a comment from item %s';
$txt['aeva_admin_modlog_delete_report_item_report'] = 'Deleted a report on item #%s';
$txt['aeva_admin_modlog_delete_report_comment_report'] = 'Deleted a report on comment #%s';
$txt['aeva_admin_modlog_delete_item_item_report'] = 'Deleted reported item #%s';
$txt['aeva_admin_modlog_delete_item_comment_report'] = 'Deleted reported comment #%s';
$txt['aeva_admin_modlog_ban_add'] = 'Banned <a href="%s">%s</a>';
$txt['aeva_admin_modlog_ban_delete'] = 'Lifted ban on <a href="%s">%s</a>';
$txt['aeva_admin_modlog_prune_item'] = 'Pruned %s item(s)';
$txt['aeva_admin_modlog_prune_comment'] = 'Pruned %s comment(s)';
$txt['aeva_admin_modlog_move'] = 'Moved <a href=%s">%s</a> from album <a href="%s">%s</a> to <a href="%s">%s</a>';
$txt['aeva_admin_modlog_qsearch'] = 'Quick search by member';
$txt['aeva_admin_modlog_filter'] = 'Moderation logs filtered by <a href="%s">%s</a>';
$txt['aeva_admin_view_image'] = 'View image';
$txt['aeva_admin_live'] = 'Live from SMF-Media.com';
$txt['aeva_admin_ftp_files'] = 'Files inside the FTP folder';
$txt['aeva_admin_profile_add'] = 'Add profile';
$txt['aeva_admin_prof_name'] = 'Profile name';
$txt['aeva_admin_create_prof'] = 'Create profile';
$txt['aeva_admin_members'] = 'Members';
$txt['aeva_admin_prof_del_switch'] = 'Profile to switch albums to';
$txt['aeva_quota_profile'] = 'Membergroup quota profile';
$txt['aeva_album_hidden'] = 'Disable browsing';
$txt['aeva_album_hidden_subtxt'] = 'Enable this to prevent anyone but you from browsing this album. Its items can STILL be viewed by authorized membergroups. You may want to use this if you want to use it as a container for blog or forum post illustrations.';
$txt['aeva_allowed_members'] = 'Allowed members (read access)';
$txt['aeva_allowed_members_subtxt'] = 'Enter a comma-separated list of members whom you want to be able to view the album, even if their membergroups won\'t allow them to.';
$txt['aeva_allowed_write'] = 'Allowed members (write access)';
$txt['aeva_allowed_write_subtxt'] = 'Enter a comma-separated list of members whom you want to be able to upload to the album, even if their membergroups won\'t allow them to.';
$txt['aeva_denied_members'] = 'Denied members (read access)';
$txt['aeva_denied_members_subtxt'] = 'Enter a comma-separated list of members whom you don\'t want to allow viewing this album, even if their membergroups are allowed to.';
$txt['aeva_denied_write'] = 'Denied members (write access)';
$txt['aeva_denied_write_subtxt'] = 'Enter a comma-separated list of members whom you don\'t want to allow posting to this album, even if their membergroups are allowed to.';
$txt['aeva_admin_wselected'] = 'With selected';
$txt['aeva_admin_apply_perm'] = 'Add permission';
$txt['aeva_admin_clear_perm'] = 'Clear permission';
$txt['aeva_admin_set_mg_perms'] = 'Set permissions like this group';
$txt['aeva_admin_readme'] = 'Read Me';
$txt['aeva_admin_changelog'] = 'Changelog';

// Admin error strings
// Escape single quotes twice (\\\' instead of \') for aeva_admin_album_confirm, otherwise it won't work.
$txt['aeva_admin_album_confirm'] = 'Are you sure you want to delete this album? This will also remove all items and comments inside the album';
$txt['aeva_admin_name_left_empty'] = 'Name was left empty';
$txt['aeva_admin_invalid_target'] = 'Invalid target specified';
$txt['aeva_admin_invalid_position'] = 'Invalid position specified';
$txt['aeva_admin_prune_invalid_days'] = 'Invalid &quot;days&quot; data specified';
$txt['aeva_admin_no_albums'] = 'No albums specified';
$txt['aeva_admin_rm_selected'] = 'Remove selected';
$txt['aeva_admin_rm_all'] = 'Remove all';
$txt['aeva_report_not_found'] = 'Report not found';
$txt['aeva_admin_bans_mems_empty'] = 'Members were not specified';
$txt['aeva_admin_bans_mems_not_found'] = 'Members specified were not found';
$txt['aeva_ban_not_found'] = 'Ban not found';
$txt['aeva_admin_already_banned'] = 'User is already banned';
$txt['aeva_admin_album_dir_failed'] = 'This album\'s directory couldn\'t be properly created, please make sure mgal_data/ and mgal_data/albums/ are chmodded to 0777 or 0755.';
$txt['aeva_admin_unique_permission'] = 'You must select only one option';
$txt['aeva_admin_quick_none'] = 'No option selected';
$txt['aeva_admin_invalid_groups'] = 'An invalid group selection was supplied, either the group does not exist or if you\'re copying permissions, make sure you have not selected the group you\'re copying permissions from or you have simply not selected any group';

// Admin help strings
$txt['aeva_admin_desc'] = 'Aeva Media Admin';
$txt['aeva_admin_settings_desc'] = 'This is your settings admin panel. From here you can manage the settings for Aeva Media.';
$txt['aeva_admin_embed_desc'] = 'This is the auto-embedder admin panel. From here you can enable and disable auto-embedding of external multimedia links, such as YouTube. You can also view the site list and manage allowed websites.';
$txt['aeva_admin_albums_desc'] = 'This is your albums admin panel. From here you can manage your albums and do tasks like adding, removing, editing as well as moving the albums. Clicking on the <strong>+</strong> button will give you more info about that particular album.';
$txt['aeva_admin_subs_desc'] = 'This is your submissions admin panel. From here you can see, delete and approve unapproved items, comments and albums';
$txt['aeva_admin_maintenance_desc'] = 'This is your maintenance area; it contains some useful functions.';
$txt['aeva_admin_modlog_desc'] = 'This is your moderation log; it holds information about any moderation activity performed in your gallery.';
$txt['aeva_admin_reports_desc'] = 'This is your reports admin panel, here you can see and delete reported items and comments, or delete the report itself.';
$txt['aeva_admin_bans_desc'] = 'This is your bans admin panel where you can manage your gallery bans.';
$txt['aeva_admin_about_desc'] = 'Welcome to the Aeva Media Administration Area!';
$txt['aeva_admin_passwd_subtxt'] = 'Send it to users you want to share the album with. Otherwise, leave empty.';
$txt['aeva_admin_maintenance_finderror_pending'] = 'The script is still working. Currently %s out of %s items are done.<br /><br /><a href="%s">Please click here to continue.</a> Make sure you wait 1-2 seconds to avoid overload.';
$txt['aeva_admin_finderrors_1'] = 'The following errors were discovered when searching for errors';
$txt['aeva_admin_finderrors_missing_db_file'] = 'The DB entry of file #%s, used with item #<a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_db_thumb'] ='The DB entry of thumbnail #%s, used with item #<a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_db_preview'] ='The DB entry of preview #%s, used with item <a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_physical_file'] = 'The physical file #%s, used with item <a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_physical_thumb'] = 'The physical thumbnail #%s, used with item <a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_physical_preview'] = 'The physical preview file #%s, used with item <a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_album'] = 'The album #%s, associated with the item <a href="%s">%s</a>, is missing.';
$txt['aeva_admin_finderrors_missing_last_comment'] = 'The comment #%s, associated with item <a href="%s">%s</a> as its last comment, is missing.';
$txt['aeva_admin_finderrors_parent_album_access'] = 'Album #%s has been updated to remove groups that don\'t have access to its parent album.';
$txt['aeva_admin_finderrors_done'] = 'Checking for errors is done. No errors found!';
$txt['aeva_admin_prune_done_items'] = 'Pruning of items completed! %s items, %s comments and %s files deleted';
$txt['aeva_admin_prune_done_comments'] = 'Pruning of comments completed! %s comments deleted';
$txt['aeva_admin_maintenance_prune_item_help'] = 'Pruning items, you can prune items which are older than &quot;x&quot; days which you can define below. There are several other options which can be used as parameters <b>but are optional</b>. Albums would be either specifically selected or all.';
$txt['aeva_admin_maintenance_prune_com_help'] = 'Pruning comments, you can prune comments here which are &quot;x&quot; days old from all or specific albums.';
$txt['aeva_admin_maintenance_checkfiles_done'] = 'Unneeded files have been deleted, for a total of %s files, freeing %s kilobytes of space.';
$txt['aeva_admin_maintenance_checkfiles_no_files'] = 'No extra files found';
$txt['aeva_admin_maintenance_checkfiles_found'] = 'Found %s unneeded files using up %s kilobytes of extra space. <a href="%s">Click here</a> to remove them.';
$txt['aeva_admin_maintenance_checkorphans_done'] = 'All orphan files have been deleted, for a total of %s files:';
$txt['aeva_admin_maintenance_checkorphans_no_files'] = 'No orphan files found';
$txt['aeva_admin_maintenance_clear_pending'] = 'The script is still working. Currently %s out of %s items are done.<br /><br /><a href="%s">Please click here to continue.</a> Make sure you wait 1-2 seconds to avoid overload.';
$txt['aeva_admin_maintenance_clear_done'] = 'All files have been successfully renamed.';
$txt['aeva_admin_installed_on'] = 'Installed on';
$txt['aeva_admin_ffmpeg'] = ' FFMPEG';
$txt['aeva_admin_smf_ver'] = 'SMF Version';
$txt['aeva_admin_php_ver'] = 'PHP Version';
$txt['aeva_admin_about_header'] = 'Server information and installed modules';
$txt['aeva_admin_credits_thanks'] = 'The people who made Aeva Media possible!';
$txt['aeva_admin_credits'] = 'Credits';
$txt['aeva_admin_thanks'] = 'Thanks to...';
$txt['aeva_admin_about_modd'] = 'Gallery moderators and managers';
$txt['aeva_admin_managers'] = 'Managers';
$txt['aeva_admin_moderators'] = 'Moderators';
$txt['aeva_admin_icon_edit_subtext'] = 'If you re-upload the icon, the old one will be overwritten. Leave empty to keep the current icon.';
$txt['aeva_admin_bans_mems_empty'] = 'Members were not specified';
$txt['aeva_admin_expires_on_help'] = 'Should be entered in &quot;days&quot; from now';
$txt['aeva_admin_modlog_desc'] = 'This is the moderation log, here you will find the log of all the moderation action that took place. Please remember that deleting a moderation log will make it lost forever.';
$txt['aeva_admin_ftp_desc'] = 'This section allows you to import items into albums via a remote folder on the server. This can be helpful to upload very large files that PHP won\'t accept in a regular upload process.';
$txt['aeva_admin_ftp_help'] = 'Here is the file listing inside the {Data_dir}/ftp folder. Please select the target album for each folder, and start importing.';
$txt['aeva_admin_ftp_halted'] = 'The script is taking a short break to avoid server overload, currently completed %s of %s. The import will resume automatically.';
$txt['aeva_admin_perms_desc'] = 'Here you can manage the different permission profiles, which allow you to control per-album accesses.';
$txt['aeva_admin_prof_del_switch_help'] = 'If you want to delete a profile that is currently being used, the albums using it will require another profile to be assigned to them.';
$txt['aeva_admin_quotas_desc'] = 'Here you can manage the Membergroup Quota profiles';
$txt['aeva_admin_safe_mode'] = 'PHP\'s Safe Mode is enabled. It may cause conflicts with Aeva Media. Please <span style="color: red">disable it</span> or read the documentation in the MGallerySafeMode.php file!';
$txt['aeva_admin_safe_mode_none'] = 'PHP\'s Safe Mode is disabled, so it won\'t cause any trouble to Aeva Media. Good thing.';
$txt['aeva_admin_perms_warning'] = '<strong>Warning</strong>: this page is only for album permissions. General access permissions for Aeva Media are to be set membergroup by membergroup, in the regular <a href="%s">administration area</a>.';

// Exif strings
$txt['aeva_exif'] = 'Exif';
$txt['aeva_imagemagick'] = 'ImageMagick';
$txt['aeva_gd2'] = 'GD2';
$txt['aeva_MW'] = 'MagickWand';
$txt['aeva_imagick'] = 'IMagick';
$txt['aeva_exif_duration'] = 'Duration';
$txt['aeva_exif_bit_rate'] = 'Bit rate';
$txt['aeva_exif_frame_count'] = 'Frame count';
$txt['aeva_exif_audio_codec'] = 'Audio codec';
$txt['aeva_exif_video_codec'] = 'Video codec';
$txt['aeva_exif_copyright'] = 'Copyright';
$txt['aeva_exif_make'] = 'Make';
$txt['aeva_exif_model'] = 'Model';
$txt['aeva_exif_yres'] = 'Y-Resolution';
$txt['aeva_exif_xres'] = 'X-Resolution';
$txt['aeva_exif_resunit'] = 'Resolution unit';
$txt['aeva_exif_datetime'] = 'Date';
$txt['aeva_exif_flash'] = 'Flash';
$txt['aeva_exif_focal_length'] = 'Focal length';
$txt['aeva_exif_orientation'] = 'Orientation';
$txt['aeva_exif_xposuretime'] = 'Exposure time';
$txt['aeva_exif_not_available'] = 'No Exif data found';
$txt['aeva_exif_entries'] = 'View all entries';
$txt['aeva_exif_fnumber'] = 'FNumber';
$txt['aeva_exif_iso'] = 'ISO Value';
$txt['aeva_exif_meteringMode'] = 'Metering Mode';
$txt['aeva_exif_digitalZoom'] = 'Digital Zoom';
$txt['aeva_exif_contrast'] = 'Contrast';
$txt['aeva_exif_sharpness'] = 'Sharpness';
$txt['aeva_exif_focusType'] = 'Focus Type';
$txt['aeva_exif_exifVersion'] = 'Exif version';

// ModCP
$txt['aeva_modcp'] = 'Moderation';
$txt['aeva_modcp_desc'] = 'This is the moderation center of the gallery, here you can manage submissions and reports sent by the users of gallery as well as see the moderation log';

// Per-album Permissions
$txt['permissionname_aeva_download_item'] = 'Download items';
$txt['permissionname_aeva_add_videos'] = 'Add video files';
$txt['permissionname_aeva_add_audios'] = 'Add audio files';
$txt['permissionname_aeva_add_docs'] = 'Add documents';
$txt['permissionname_aeva_add_embeds'] = 'Add embedded files';
$txt['permissionname_aeva_add_images'] = 'Add pictures';
$txt['permissionname_aeva_rate_items'] = 'Rate items';
$txt['permissionname_aeva_edit_own_com'] = 'Edit own comments';
$txt['permissionname_aeva_report_com'] = 'Report comment';
$txt['permissionname_aeva_edit_own_item'] = 'Edit own items';
$txt['permissionname_aeva_comment'] = 'Comment in items';
$txt['permissionname_aeva_report_item'] = 'Report items';
$txt['permissionname_aeva_auto_approve_com'] = 'Auto-approve comments';
$txt['permissionname_aeva_auto_approve_item'] = 'Auto-approve items';
$txt['permissionname_aeva_multi_upload'] = 'Mass Upload';
$txt['permissionname_aeva_whoratedwhat'] = 'View who rated what';
$txt['permissionname_aeva_multi_download'] = 'Mass Download';

// Custom fields
$txt['aeva_cf_invalid'] = 'The value submitted for %s is invalid';
$txt['aeva_cf_empty'] = 'Field %s was left empty';
$txt['aeva_cf_bbc'] = 'This field can have BBCode';
$txt['aeva_cf_required'] = 'This field is required';
$txt['aeva_cf_desc'] = 'Here you can manage the custom fields';
$txt['aeva_cf'] = 'Custom fields';
$txt['aeva_admin_labels_fields'] = 'Custom fields';
$txt['aeva_cf_name'] = 'Field name';
$txt['aeva_cf_type'] = 'Field type';
$txt['aeva_cf_add'] = 'Create a new field';
$txt['aeva_cf_req'] = 'Required';
$txt['aeva_cf_searchable'] = 'Searchable';
$txt['aeva_cf_bbcode'] = 'BBC';
$txt['aeva_cf_editing'] = 'Adding/editing a custom field';
$txt['aeva_cf_text'] = 'Text';
$txt['aeva_cf_radio'] = 'Radio buttons';
$txt['aeva_cf_checkbox'] = 'Checkboxes';
$txt['aeva_cf_textbox'] = 'Text box';
$txt['aeva_cf_select'] = 'Select dropdown';
$txt['aeva_cf_options'] = 'Field options';
$txt['aeva_cf_options_stext'] = 'Add options for the fields, only valid if the field types are checkbox, select or radio. Use comma (,) as a separator';

// Who's online strings
$txt['aeva_wo_home'] = 'Viewing the <a href="' . $scripturl . '?action=media">gallery home</a>';
$txt['aeva_wo_admin'] = 'Administrating the gallery';
$txt['aeva_wo_unseen'] = 'Viewing an <i>unseen</i> item in the gallery';
$txt['aeva_wo_search'] = 'Searching the gallery';
$txt['aeva_wo_item'] = 'Viewing &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_album'] = 'Viewing the album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_add'] = 'Adding an item in the album &quot;<a href="'.$scripturl.'?action=media;sa=album;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_edit'] = 'Editing &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_comment'] = 'Commenting in &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_reporting'] = 'Reporting &quot;<a href="'.$scripturl.'?action=media;sa=item;in=%s">%s</a>&quot; in the gallery';
$txt['aeva_wo_stats'] = 'Viewing gallery\'s statistics';
$txt['aeva_wo_vua'] = 'Viewing an album\'s control panel in the gallery';
$txt['aeva_wo_ua'] = 'Viewing an album\'s index in the gallery';
$txt['aeva_wo_unknown'] = 'Doing some unknown action in the gallery';
$txt['aeva_wo_hidden'] = 'Somewhere in the gallery, in a place you can\'t see... Scary huh?';

// Help popup for the SMG tag...
$txt['aeva_smg_tag'] = '
	<h1>[smg] tag ~ the basics</h1>
	A quick example:
	<br /><b>[smg id=123 type=preview align=center width=400 caption="Hello, world!"]</b>
	<br />This will show in your posts a center-aligned mid-size (preview) picture, resized to 400 pixels wide, with a caption below it. All parameters are optional, except for the item ID.
	<br />
	<br /><b>[smg id=1 type=album]</b>
	<br />This will show in your posts the latest items in your first album. They will be shown using the box type (see below).
	<br /><br />
	<b>Possible values:</b>
	<br />- type=<i>normal, box, link, preview, full, album</i>
	<br />- align=<i>none, left, center, right</i>
	<br />- width=<i>123</i> (in pixels)
	<br />- caption=<i>&quot;Caption text&quot;</i> or caption=<i>SingleWordText</i>
	<br /><br />
	<b>id</b>
	<ul class="normallist">
		<li>All items are identified by a specific number which you can see in its URL. Just use it here. This is the only parameter that is <b>NOT</b> optional.
		You may specify several items by separating them with commas, as in "[smg id=1,2,3 type=album]".</li>
	</ul>
	<br />
	<b>type</b>
	<ul class="normallist">
		<li><b>normal</b> (default, except if set up differently) - show the thumbnail. Click on it to show a preview.</li>
		<li><b>av</b> - embed an audio or video item within a player. If you do not use this parameter, the item\'s thumbnail will show up as expected, but clicking on it will load the file directly. You don\'t want that to happen. Really.</li>
		<li><b>box</b> - show the thumbnail box, with full details, as in Aeva Media\'s Gallery pages. Clicking on the thumbnail will lead you to the item page.</li>
		<li><b>link</b> - just like the default, except that the caption is clickable and leads you to the item page. If no caption is set, a default link will be shown instead.</li>
		<li><b>preview</b> (may be default if set up accordingly) - show the preview picture (halfway between thumbnail and full picture.)</li>
		<li><b>full</b> (may be default if set up accordingly) - show the full picture. Make sure you set the width parameter!</li>
		<li><b>album</b> - show the latest items from the album(s) indicated in id. They will be shown using the <b>box</b> type.</li>
	</ul>
	<br />
	<b>align</b>
	<ul class="normallist">
		<li><b>none</b> (default) - normal alignment. Will not allow thumbnails to its right or left.</li>
		<li><b>left</b> - left-align the thumbnail. Use several left-aligned [smg] tags to show thumbnails next to each other.</li>
		<li><b>center</b> - center-align the thumbnail. Will not allow thumbnails to its right or left, except if showing them in this order: [smg align=left][smg align=right][smg align=center]</li>
		<li><b>right</b> - same as <i>left</i>, but right-aligned. You got it.</li>
	</ul>
	<br />
	<b>width</b>
	<ul class="normallist">
		<li>Any number higher than zero will do. This parameter is only needed if you want to force a specific width.</li>
		<li>Set the tag type according to the desired size. For instance, if your thumbnails have a default width of 120, and previews are 500 pixels wide, use [smg type=preview] if you\'re forcing a width of 300 to 500 pixels, otherwise the resulting thumbnail will be very blurry.</li>
	</ul>
	<br />
	<b>caption</b>
	<ul class="normallist">
		<li>Show a caption below the thumbnail (if type is set to link, the caption will be clickable and lead you to the item page.)</li>
		<li>Any string will do. If it contains spaces or brackets, be sure to enclose it between &quot;double quotes&quot;.</li>
	</ul>';

$txt['aeva_permissions_help'] = 'Here you can add/edit/delete the various permission profiles. The profiles can be assigned to one or multiple albums and the assigned albums will follow that permission set.';
$txt['aeva_permissions_undeletable'] = 'You cannot delete this profile, as it is a default profile';

?>