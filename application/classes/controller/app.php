<?php
/**
 * Created by JetBrains PhpStorm.
 * User: letuboy
 * Date: 2/26/11
 * Time: 12:32 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Controller_App extends Controller_Template {

    public function before() {
        parent::before();

        Util_Analytics_Engine::record($this->request);

        if($this->template instanceof View) {
            $this->template->session = Session::instance();
        }

        if($this->layout instanceof View) {
            $this->layout->session = Session::instance();
        }
    }

    public function after() {
        if(Session::instance()->get('user_id') && $this->layout && !isset($this->layout->member)) {
            $this->layout->member = Model_Member::loadFromID(Session::instance()->get('user_id'));
        }

        parent::after();
        
        if($id = Session::instance()->get('user_id')) {
          $query = "UPDATE myMembers SET last_active = NOW() WHERE myMembers.id = $id";

          DB::query(Database::UPDATE, $query)
            ->execute();
        }
    }

	public function action_login($admin = false) {
		$post = $this->request->post();
		
		if($post) {
			$member = Model_Member::checkLogin($post, $admin);
	
			if($member instanceof Model_Member) {
				$member->login($admin);
		
				if(Session::instance()->get('refer')) {
					$this->request->redirect("/refer");
				} else {
					if($admin) {
						$this->request->redirect("/admin");
					} else {
						$this->request->redirect("/");
					}
				}
			} else {
				$this->template->message = $member;
				$this->template->email = $post['email'];
			}
		}
	}

    /**
     * Check the session, whether it exists or not. Or whether it doesn't exist or not.
     *
     * @param  $redirPath Path to redirect too
     * @param bool $exists If true, redirect if session exists. If false, redirect if the session doesn't exist.
     * @return bool
     */
    protected function _checkSession($redirPath, $exists = false) {
        if($exists) {
            if(Session::instance()->get('user_id')) {
                $this->_protectedRedirect($redirPath);
            } else {
                return true;
            }
        } else {
            if(!Session::instance()->get('user_id')) {
                $this->_protectedRedirect($redirPath);
            } else {
                return true;
            }
        }
    }
    
    protected function _protectedRedirect($redirectPath) {
        if($this->request->is_ajax()) {
            echo json_encode(array('error' => $redirPath));
            
            exit;
        } else {
            $this->request->redirect($redirectPath);
        }
    }

    /**
     * Require that the user be logged in.
     *
     * @return bool
     */
    protected function _requireAuth($path = "/login") {
        return $this->_checkSession($path, false);
    }
}
