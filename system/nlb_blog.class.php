<?PHP

/*
	------------------------------------------------		
			NewLife Blogging System Version 3		
	------------------------------------------------
		Developed by sevengraff
		Nick Fun <nick@sevengraff.com>
		Jan-March 2004
		Liscensed under the GNU GPL
	------------------------------------------------
*/

/**
 * Interface to blogs.
 * Main purpose is to format data from DB so that It can be used by ETS
 *
 * @package NLB3
 * @author Nick F <nick@sevengraff.com>
 * @date 12-19-03
 */
class nlb_blog {
	
	var $smiles;
	var $blogid;
	var $authorid;
	var $sql;
	var $avatar;
	var $data;
	var $date_format;
	var $official;
	var $offset_server;
	var $offset_user;
	
	/**
	 * @return VOID
	 * @desc Constructor. MUST pass in a sqldb2 object.
	 * @date 12-19-03
	 */
	function nlb_blog( & $db, $data = false ) {
		$this->sql =& $db;
		if( $data && is_array($data) ) {
			$this->setData( $data );
		}
		$this->avatar = false;
		// list of all the fields in db_blogs
		$this->official = array(
			'author_id',
			'date', 'subject', 'body',
			'custom', 'mood', 'comments',
			'html', 'smiles', 'bb',
			'access', 'views'
		);
		$this->offset_server = false;
		$this->offset_user = false;
	}
	
	/**
	 * @return VOID
	 * @param STRING
	 * @desc Sets the custom text value to use.
	 * @date 12-19-03
	 */
	function setDate( $text ) {
		$this->date_format = $text;
	}
	
	/**
	 * @return VOID
	 * @desc Will fetch a single blog from the database and store it. will not format yet.
	 * @date 12-19-03
	 */
	function fetchFromDb( $id ) {
		if( $id ) {
			$this->blog_id = $id;
		}
		$this->data = $this->sql->getArray('# Get a blog
		SELECT u.*, b.* 
		FROM ' . db_users . ' as u, ' . db_blogs . ' as b
		WHERE b.blog_id = ' . $id . ' AND u.user_id = b.author_id
		LIMIT 1;');
		$this->author_id = $this->data['author_id'];
	}
	
	/**
	 * @return void
	 * @param string $item
	 * @param string $value
	 * @desc sets local $data[$item] to $value
	 * @date 02-01-04
	 */
	function setItem( $item, $value ) {
		$this->data[$item] = $value;
	}
	
	/**
	 * @return void
	 * @desc updates the blog to the database. use addslashes BEFORE calling this method
	 * @date 02-01-04
	 */
	function updateToDB() {
		$q = " # Updating blog
		UPDATE " . db_blogs . " SET \n";
		$c = count( $this->data );
		$i = 0;
		foreach( $this->data as $item => $val ) {
			if( in_array( $item, $this->official ) ) {
				$i++;
				$q .= '`' . $item . '` = "' . $this->data[$item] . '" ';
				$q .= ", \n";
			}
		}
		$q = substr( $q, 0, -4 );	// to remove last ", \n"
		$q .= " \nWHERE blog_id = " . $this->data['blog_id'] . ";";
		$this->sql->query( $q );
	}
	
	/**
	 * @return VOID
	 * @param ARRAY
	 * @desc Sets properties for later use.
	 * @date 12-19-03
	 */
	function setData( $d ) {
		$this->data = $d;
		$this->blogid = $d['blog_id'];
		$this->authorid = $d['author_id'];
		foreach( $this->data as $key => $val ) {
			// we are assuming this came from a DB and has not been altered
			//$this->data[$key] = stripslashes( $val );
		}
	}
	
	/**
	 * @return void
	 * @desc re-counts the number of comments a blog has gotten. Will *NOT* update to db by itself
	 * @date 02-01-04
	 */
	function recountComments() {
		if( !isset( $this->data['blog_id'] ) ) {
			return;
		}
		$num = $this->sql->getArray( "SELECT count(*) as c 
		FROM " . db_comments . " 
		WHERE parent_id = " . $this->data['blog_id'] . ";" );
		$count = $num['c'];
		$this->data['comments'] = $count;
	}
	
	/**
	 * @return array
	 * @param object
	 * @desc Gets newest blogs and formats them for ets.
	 * @date 01-16-04
	 */
	function getRecent( & $config ) {
		$num = $config->get('recent_blog_num');
		$dateformat = $config->get('recent_blog_date');
		$all = $this->sql->getAllArray(" # Get recent blogs
		SELECT b.author_id, b.blog_id, b.subject, b.comments, b.date, u.username
		FROM " . db_blogs . " as b, " . db_users . " as u
		WHERE b.author_id = u.user_id AND b.access = " . access_public . "
		ORDER BY date DESC
		LIMIT 0, $num;");
		$recent_blogs = array();
		$i=0;
		foreach( $all as $row ) {
			stripslashes_array( $row );
			$recent_blogs[$i]->author 				= $row['username'];
			$recent_blogs[$i]->author_url_blogs 	= build_link('blog.php', array('user'=>$row['author_id']));
			$recent_blogs[$i]->author_url_profile 	= build_link('profile.php', array('user'=>$row['author_id']));
			$recent_blogs[$i]->url_blog 			= build_link('blog.php', array('id' => $row['blog_id']));
			//$recent_blogs[$i]->subject 				= htmlspecialchars( $row['subject'] );
			$sub = $row['subject'];
			// truncate large subjects
			if( strlen($sub) > 30) {
				$sub = substr($sub, 30) . "...";
			}
			$recent_blogs[$i]->subject = htmlspecialchars($sub);
			if( $row['comments'] >= 0 ) {
				$recent_blogs[$i]->comments = $row['comments'];
			}
			// timezone settings
			if( $this->offset_server && $this->offset_user ) {
				$servertime = date_offset( $row['date'], $this->offset_server );
				$localtime = date_offset( $servertime, $this->offset_user );
				$recent_blogs[$i]->date = date( $dateformat, $localtime );
			} else {
				// no timezone settings, user is probally not loged in.
				$recent_blogs[$i]->date = date( $dateformat, $row['date'] );
			}
			
			$i++;
		}
		//debug( $ets ); die();
		return $recent_blogs;
	}

	function setDateOffset( $server, $user ) {
		$this->offset_server = $server;
		$this->offset_user = $user;
	}
	
	/**
	 * @return OBJECT
	 * @param [ARRAY]
	 * @desc Formats data to be used by ETS. Assumes extra data has been passed.
	 * @date 12-19-03
	 */
	function format( $d = false, & $user , $lang_edit = 'edit'  ) {
		if( $d ) {
			$this->setData( $d );
		}
		$allowed = array('author', 'access', 'subject', 'body', 'mood', 'views', 'custom_title');
		foreach( $this->data as $key => $val ) {
			if( in_array($key, $allowed) ) {
				$r->{$key} = $val;
			}
		}
		if( !empty( $this->data['mood'] ) ) {
			$r->mood = $this->data['mood'];
		}
		if( !empty( $this->data['custom_text'] ) && !empty( $this->data['custom_title'] ) ) {
			$r->custom_text = $this->data['custom_text'];
		}
		if( $this->data['comments'] != -1 ) {
			$r->comments = true;
			$r->comments_num = $this->data['comments'];
			if( $this->data['access'] == access_news ) {	// process as news item
				$r->comments_url = build_link('index.php', array('action'=>'comment', 'id'=>$this->data['blog_id']));
			} else {
				$r->comments_url = build_link('blog.php', array('id'=>$this->data['blog_id']));
			}
		} else {
			$r->comments = false;
		}
		$r->author_url_profile 	= build_link('profile.php', array('user'=>$this->data['author_id']));
		$r->author_url_blogs 	= build_link('blog.php', array('user'=>$this->data['author_id']));
		if( $this->data['html'] == 0 ) {
			$r->body = htmlspecialchars( $r->body );
		}
		if( $this->data['bb'] == 1 ) {
			$r->body = insertBBCode( $r->body );
		}
		if( $this->data['smiles'] == 1 ) {
			$r->body = $this->addSmiles( $r->body );
		}		
		$r->body = nl2br( $r->body );
		
		// Set to users local timezone
		if( $this->offset_server && $this->offset_user ) {
			$servertime = date_offset( $this->data['date'], $this->offset_server );
			$localtime = date_offset( $servertime, $this->offset_user );
			$r->date = date( $this->date_format, $localtime );
		} else {
			// no timezone settings, user is probally not loged in.
			$r->date = date( $this->date_format, $this->data['date'] );
		}
		
		// admin-only edit link?
		if( $this->data['access'] != access_news && $user->isAllowed('admin') ) {
			$adminurl = script_path . 'admincp.php?action=edit_blog&id=' . $this->data['blog_id'];
			$r->body .= ' [<a href="' . $adminurl . '">' . $lang_edit . '</a>]';
		}
		return $r;		
	}
	
	/**
	 * @return array
	 * @param int $id
	 * @param string
	 * @param string
	 * @param object nlb_user
	 * @param string
	 * @desc Grabs and formats all the comments to blog $id and sets them up for ETS
	 * @date 02-10-04
	 */
	function getComments( $id, $date_format, $lang_anon, & $user, $lang_edit ) {
		// get ones posted by real users
		$real = $this->sql->getAllArray('# Grab real comments
		SELECT c.comment_id, c.author_id, c.date, c.body, u.username
		FROM ' . db_comments . ' AS c, ' . db_users . ' AS u
		WHERE c.parent_id = '. $id . ' AND c.author_id = u.user_id
		ORDER BY c.date ASC;');
		// get guest posts
		$guest = $this->sql->getAllArray('# Grab guest comments
		SELECT comment_id, author_id, date, body
		FROM ' . db_comments . '
		WHERE author_id = -1 AND parent_id = ' . $id . '
		ORDER BY date ASC;');
		
		/*
			Because I'm using two querys to grab the comments, I have the problem of sorting
			the results. I'm throwing all the results together in $grab. Then I go throuh them
			and build a new array, with the date of the post as the key. Now I can use ksort()
			to sort by key (asc) and the comments will be in the propper order. The key doesn't
			matter in the templates, as ETS will just loop through them in order. Probally 
			costs more memory this way, but the job gets done.
			
			We won't have to bulid $grab if there are only one type of comments, so im trying
			to detect if ksort is needed or not below.
		*/
		
		if( empty( $real ) && empty( $guest ) ) {
			$all = array();		// no comments
		} elseif( empty( $real ) ) {
			$all = $guest;		// only guest comments
		} elseif( empty( $guest ) ) {
			$all = $real;		// only real comments
		} else {
			// a mix of real and guest comments.
			$grab = array_merge( $real, $guest);
			foreach( $grab as $val ) {
				$all[$val['date']] = $val;
				
			}
			ksort( $all );	
		}
		
		// loop through real, get id nubers to check for avatars
		$av_ins = false;
		$avatars = array();
		if( count($real) != 0 ) {
			$av_ins = '(';
			foreach( $real as $r ) {
				$av_ins .= $r['author_id'] . ', ';
			}
			$av_ins = substr($av_ins, 0, -2);
			$av_ins .= ')';
			$r = $this->sql->query('SELECT owner_id, isCustom, file, type
			FROM ' . db_avatars . '
			WHERE owner_id IN' . $av_ins . ' AND type != 2;');
			while( $row = mysql_fetch_assoc($r) ) {
				if( isset($avatars[ $row['owner_id'] ] ) && $avatars[ $row['owner_id'] ]['type'] != 3 ) {
					$avatars[ $row['owner_id'] ] = $row;
				}
				if( !isset($avatars[ $row['owner_id'] ] ) ) {
					$avatars[ $row['owner_id'] ] = $row;
				}
			}
		}

		$c = array();
		$i = 0;
		foreach( $all as $comment ) {
			$c[$i]->date = date( $date_format, $comment['date'] );
			//$body = stripslashes( $comment['body'] );
			$body = $comment['body'];
			$body = htmlspecialchars( $body );
			$body = nl2br( $body );
			$body = $this->addSmiles( $body );
			$body = insertBBCode( $body );
			$c[$i]->body = $body;			
			if( $comment['author_id'] == -1 ) {
				// a guest post!
				$c[$i]->author = $lang_anon;
				$c[$i]->guest = true;
			} else {
				// comment by normal user!
				$c[$i]->author 				= $comment['username'];
				$c[$i]->author_url_blog 	= build_link('blog.php', array('user'=>$comment['author_id']));
				$c[$i]->author_url_profile 	= build_link('profile.php', array('user'=>$comment['author_id']));
				// avatar check
				if( isset($avatars[ $comment['author_id'] ] ) ) {
					if( $avatars[ $comment['author_id'] ]['isCustom'] == 1 ) {
						$c[$i]->avatar_url = script_path . 'avatars/' . $avatars[$comment['author_id']]['file'];
					} else {
						$c[$i]->avatar_url = script_path . 'avatars/default/' . $avatars[$comment['author_id']]['file'];
					}
					$c[$i]->avatar = '<img src="' . $c[$i]->avatar_url . '" />';
				}
			}
			
			// admin-only link to edit comment?
			if( $user->isAllowed('admin') ) {
				$admin_url = script_path . 'admincp.php?action=edit_comment&id=' . $comment['comment_id'];
				$c[$i]->body .= ' [<a href="' . $admin_url . '">' . $lang_edit . '</a>]';
			}
			$i++;
		}
		
		return $c;
	}
	
	/**
	 * @return string
	 * @param string $text
	 * @desc will add smiles to $text
	 * @date 01-29-04
	 */
	function addSmiles( $text ) {
		if( empty( $this->smiles ) ) {
			$this->smiles = $this->sql->getAllArray("SELECT code, image FROM " . db_smiles . ";");
		}
		foreach( $this->smiles as $row ) {
			$text = str_replace( $row['code'], '<img src="' . script_path . 'smiles/' . $row['image'] . '" border="0" />', $text );
		}
		return $text;
	}
	
	/**
	 * @return void
	 * @desc Adds one view
	 * @date 02-01-04
	 */
	function addView() {
		if( !isset( $this->data['blog_id'] ) ) {
			return;
		}
		$this->sql->query("UPDATE " . db_blogs . " SET views = views + 1 WHERE blog_id = " . $this->data['blog_id'] . " ;");
		$this->data['views']++;
	}
	
	/**
	 * @return void
	 * @param int $id
	 * @desc Deletes blog $id and all comments on it.
	 * @date 02-10-04
	 */
	function delete( $id ) {
		$this->sql->query('DELETE FROM ' . db_comments . ' WHERE parent_id="' . $id . '";');
		$this->sql->query('DELETE FROM ' . db_blogs . ' WHERE blog_id="' . $id . '";');
	}
	
	/**
	 * @return void
	 * @param int
	 * @desc Deletes a single comment. Updates comment count on blog.
	 */
	function deleteComment( $id ) {
		$get = $this->sql->getArray('SELECT parent_id FROM ' . db_comments . ' WHERE comment_id = ' . $id . ';');
		$this->sql->query('UPDATE ' . db_blogs . ' SET comments = comments - 1 WHERE blog_id = ' . $get['parent_id'] . '; ');
		$this->sql->query('DELETE FROM ' . db_comments . ' WHERE comment_id = ' . $id . '; ');
	}

	/**
	 * @return VOID
	 * @param ARRAY
	 * @desc Inserts a new blog with the given data. Assumes ALL fields are filled. Will NOT call addslashes().
	 * @date 12-19-03
	 */
	function newBlog( & $newb ) {

		if( !isset( $newb['blog_id'] ) ) {
			$newb['blog_id'] = "";
		}
		$query = 'INSERT INTO ' . db_blogs . "
( `blog_id` , `author_id` , `date` , `subject` , `body` , `custom` , `mood` , `comments` , `html` , `smiles` , `bb` , `access` , `views` )
VALUES (
'{$newb['blog_id']}',
'{$newb['author_id']}', 
'{$newb['date']}', 
'{$newb['subject']}', 
'{$newb['body']}', 
'{$newb['custom']}', 
'{$newb['mood']}',
'{$newb['comments']}',
'{$newb['html']}', 
'{$newb['smiles']}', 
'{$newb['bb']}', 
'{$newb['access']}', 
'{$newb['views']}'
);";
		$this->sql->query( $query );
		if( $newb['access'] == access_public ) {
			$this->sql->query('UPDATE ' . db_users . ' SET blog_count = blog_count + 1 WHERE user_id = ' . $newb['author_id'] . ' LIMIT 1;');
		}
	}

}

?>