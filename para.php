<?php
	function wpautop($pee, $br = 1) {
	    $pee = $pee . "\n"; // just to make things a little easier, pad the end
	    $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	    // Space things out a little
	    $allblocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
	    $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	    $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	    $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
	    $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	    $pee = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $pee); // make paragraphs, including one at the end
	    $pee = preg_replace('|<p>\s*?</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	    $pee = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $pee);
	    $pee = preg_replace( '|<p>|', "$1<p>", $pee );
	    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	    $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	    $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	    $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
	    if ($br) {
	        $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
	    }
	    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	    $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	    $pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	    return $pee;
	}
?>