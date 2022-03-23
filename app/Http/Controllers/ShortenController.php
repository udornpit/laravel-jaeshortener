<?php

/*
 * The URL Shortener Controller for generating running numbers of custom radix in PHP Laravel
 *
 * @author     Udornpit Saengdee <jaefx9@gmail.com>
 * @copyright  2022 JAE-Shortener
 * @date       2022/03/23
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0
 */
namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\ShortURL;
use Illuminate\Http\Request;


/**
 * The Shortener Controller Class
 *
 * Use this Controller to generate unique URL running numbers (strings)
 *
 * @category   Laravel
 *
 * @author     Udornpit Saengdee <jaefx9@gmail.com>
 */
class ShortenController extends Controller
{
    /**
     * @var string The custom radix with 106 unique numbers (different characters)
     */
    protected $radix106 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรลวศษสหฬอฮ";
    protected $max;

    /**
     * @var string The current/start running number and digit design
     */
    protected $cur = "AAAAAAAAAA";
    protected $len;

    protected $key = "";
    protected $dest = "";
    protected $short = "";
    protected $visit = 0;
    protected $user_id;


    /**
     * Generate a running number (string) of custom radix
     *
     * @param string $c The current running number
     * @param string $b The custom base/radix
     * @param int $m The last/biggest digit of custom radix
     * @param int $l The size of running number
     *
     * @return string The generated running number (string)
     * 
     * ---------------------------------------------------
     * @date       2022/03/21
     * @author     Udornpit Saengdee <jaefx9@gmail.com>
     */
    public function keyGenerate($c, $b, $m, $l)
    {
        $r = "";
        $s = false;
	    for($i = $l-1; $i >= 0 ; $i--) {
        	if ($i+1 == $l) {
        		if ($c[$i] === $m) {
        	    	if ($i === 0) {
        	        	return false;
        	        } else {
        	        	$r = $b[0] . $r;
        	        }    	
        	    } else {
        	    	if ($s === false) {
        	        	$r = $b[strpos($b, $c[$i]) + 1] . $r;
        	            $s = !$s;
        	        } else {
        	        	$r = $c[$i] . $r;
        	        }        	
        	    }
        	} else {
            	$t = substr($c, $i+1);
                $ct = function () use ($t, $m) {
                	$tl = strlen($t);
                	for ($j = $tl - 1; $j >= 0; $j--) {
                    	if ($t[$j] !== $m) return false;
                    }
                    return true;
                };

        		if ($c[$i] === $m && $ct()) {
        	    	if ($i === 0) {
        	        	return false;
        	        } else {
        	        	$r = $b[0] . $r;
        	        }    	
        	    } else {
        	    	if ($s === false) {
        	        	$r = $b[strpos($b, $c[$i]) + 1] . $r;
        	            $s = !$s;
        	        } else {
        	        	$r = $c[$i] . $r;
        	        }        	
        	    }
        	} 	
        }
        return $r;
    }

    // to store short url in database
    public function create(Request $request)
    {
        $this->max = $this->radix106[strlen($this->radix106) - 1];
        $this->len = strlen($this->cur);

        if ($last = ShortURL::orderBy('id', 'desc')->first()) {
            $this->cur = $last->key;
            $this->len = strlen($this->cur);
            $this->key = $this->keyGenerate(
                $this->cur,
                $this->radix106,
                $this->max,
                $this->len
            );
        } else {
            $this->key = $this->cur;
        }
        
        $this->dest = $request->dest;
        $this->short = env('APP_URL') . '/s/' . $this->key;
        $this->visit = 0;
        $this->user_id = Auth::id();

        $shortUrl = new ShortURL;
        $shortUrl->key = $this->key;
        $shortUrl->dest = $this->dest;
        $shortUrl->short = $this->short;
        $shortUrl->visit = $this->visit;
        $shortUrl->user_id = $this->user_id;
        $shortUrl->save();

        return back()->withInput(['shortUrls' => $shortUrl, 'users' => Auth::user()])->with('dbmsg', 'URL has been shortened successfully!');
    }

    // redirecting to destination url
    public function toDest($key)
    {
        $shortUrl = ShortURL::where('key', $key)->first();
        $shortUrl->visit++;
        $shortUrl->save();

        return redirect()->away($shortUrl->dest);
    }

    // delete individual url
    public function delete($id)
    {
        $shortUrl = ShortURL::where('id', $id)->first();
        $shortUrl->delete();

        return back()->with('url', 'URL has been deleted!');
    }

    // delete all urls from the target user
    public function deleteByUser(Request $request)
    {
        if ($user = User::where('name', $request->user)->first()) {
            try {
                $deleted = ShortURL::where('user_id', $user->id)->delete();
            } catch (\Throwable $th) {
                return back()->with('fail', '"' . $request->user . '", not matched!');
            }
        } else {
            return back()->with('fail', '"' . $request->user . '", not matched!');
        }

        return back()->with('url', 'All URLs of ' . $request->user . ' have been deleted successfully!');
    }

    // delete all urls from shorturls table and reset auto-increment
    public function clear()
    {
        ShortURL::truncate();
        return back()->with('url', 'The URLs table has been cleared up and reset to its original state.');
    }
}
