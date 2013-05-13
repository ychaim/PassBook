<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    var $components = array('Email');


    /**
 * index method
 *
 * @return void
 */
	public function index() {

        if ($this->isLoggedIn()) {
            $options = array(
               // 'recursive' => -1,
                'conditions' => array('User.id' => $this->user_id())
            );
            $user = $this->User->find('all', $options);
        }
        else {
            $this->redirect('/users/login_account');

        }

       // $this->User->recursive = 1;
        $this->request->data = $this->User->read(null, $this->user_id());
        $this->set(compact('user', 'user'));
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

        $this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	 function add() {

        //if ($this->isLoggedIn()) {
           // $this->redirect('/');
       // }
        $error_exist = false;

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->Session->delete('Message.flash');

            $users = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
            if(!empty($users)){
                //$this->Session->setFlash(__('The email already taken. Please, choose another.'));
                $this->ajax_response(array('error' => 'The email already taken. Please, choose another.'));
                $error_exist = true;
            }
            if($this->request->data['User']['password'] != $this->request->data['User']['password2']){
               // $this->Session->setFlash(__('Passwords don\'t match. Please, try again.'));
                $this->ajax_response(array('error' => 'Passwords don\'t match. Please, try again.'));
                $error_exist = true;
            }
            if(empty($error_exist)){
                $this->User->create();
                $this->request->data['User']['status'] = 1;
                if ($this->User->save($this->request->data)) {
                    $users = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
                    $this->Session->write($users);
                    //$url = (empty($url)) ? '/' : $url;
                    if ($this->request->is('ajax')){
                        $this->ajax_response(array('success' => true, 'user_id' => $users['User']['id']));
                    }
                   // $this->redirect($url);
                }
            }
		}
	}

	public function edit($id = null) {
        if(!$this->isAdmin()){
            if($this->user_id() != $id){
                $this->Session->setFlash(__('Access denied.'));
                $this->logout();
                $this->redirect('/users/login/');
            }
        }
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
            $users = $this->User->find('first', array('conditions' => array(
                'User.email' => $this->request->data['User']['email'],
                'User.id !=' => $this->User->id,
            )));
            if(!empty($users)){
                $this->Session->setFlash(__('The email already taken. Please, choose another.'));
                $error_exist = true;
            }
            if($this->request->data['User']['password'] != $this->request->data['User']['password2']){
                $this->Session->setFlash(__('Passwords don\'t match. Please, try again.'));
                $error_exist = true;
            }
            if(empty($error_exist)){
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
                }
            }
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        if (!$this->isAdmin()) {
            $this->Session->setFlash(__('Access denied.'));
            $this->logout();
            $this->redirect('/users/login/');
        }

        $this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->saveField('status', 0)) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    function login_account() {
        if ($this->isLoggedin()) {
            $this->redirect('/users');
            exit;
        }

        if (!empty($this->data)) {
            $this->Session->delete('Message.flash');

            $dbuser = $this->User->find('first', array('recursive' => -1, 'conditions' => array(
                'OR' => array(
                    array('User.email' => $this->data['User']['email'])
                )
            )));

            if(!empty($dbuser) && ($dbuser['User']['password'] == $this->data['User']['password'] )){
                // write the username to a session

                $this->Session->write($dbuser);
                $this->ajax_response(array('success' => true, 'user_id' => $dbuser['User']['id']));

                $this->redirect('/users');
            }
            else {
                if (!$this->request->is('ajax')) $this->Session->setFlash('Either your username or password is incorrect.', FALSE, FALSE, 'login');
                else $this->ajax_response(array('error' => 'Either your username or password is incorrect.'));
            }
        }
    }

    function login() {
        if ($this->isLoggedin()) {
            $this->redirect('/');
            exit;
        }

        if (!empty($this->data)) {
            $this->Session->delete('Message.flash');

            $dbuser = $this->User->find('first', array('recursive' => -1, 'conditions' => array(
                'OR' => array(
                    array('User.email' => $this->data['User']['email'])
                )
            )));

            if(!empty($dbuser) && ($dbuser['User']['password'] == $this->data['User']['password'] )){
                // write the username to a session

                $this->Session->write($dbuser);


                $url = (empty($url)) ? '/' : $url;
                /*if ($dbuser['User']['username'] == 'admin'){
                    $this->redirect('/admin/');
                }*/
                if(!empty($dbuser['User']['payment_token']) && $dbuser['User']['payment_token_status'] == 1){
                    $payment_token = true;
                }else {
                    $payment_token = false;
                }

                if ($this->request->is('ajax')){
                    $this->ajax_response(array('success' => true, 'user_id' => $dbuser['User']['id'], 'payment_token' => $payment_token));
                }
                $this->redirect($url);
            }
            else {
                if (!$this->request->is('ajax')) $this->Session->setFlash('Either your username or password is incorrect.', FALSE, FALSE, 'login');
                else $this->ajax_response(array('error' => 'Either your username or password is incorrect.'));
            }
        }
    }

    function payment() {
        if (!$this->isLoggedIn()) {
            $this->redirect('/users/login');
        }else {
            $options = array(
                'conditions' => array('User.id' => $this->user_id())
            );
            $user = $this->User->find('all', $options);
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('Payment');

            require_once('../Vendor/eway/lib/nusoap.php');

            // read ID, Username and Password from config.ini
            $config = parse_ini_file("../Vendor/eway/config.ini");

            // init soap client
            $client = new nusoap_client("https://www.ewaygateway.com/gateway/ManagedPaymentService/test/managedCreditCardPayment.asmx", false);
            $err = $client->getError();

            if ($err) {
                echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
                exit();
            }

            $client->namespaces['man'] = 'https://www.eway.com.au/gateway/managedpayment';
            // set SOAP header
            $headers = "<man:eWAYHeader><man:eWAYCustomerID>" . $config['eWAYCustomerID'] . "</man:eWAYCustomerID><man:Username>" . $config['UserName'] . "</man:Username><man:Password>" . $config['Password'] . "</man:Password></man:eWAYHeader>";
            $client->setHeaders($headers);

            $amount = "9.95";
            
            $requestbody = array(
//                'man:Title' => $_POST['Title'],
//                'man:FirstName' => $_POST['FirstName'],
//                'man:LastName' => $_POST['LastName'],
//                'man:Address' => $_POST['Address'],
//                'man:Suburb' => $_POST['Suburb'],
//                'man:State' => $_POST['State'],
//                'man:Company' => $_POST['Company'],
//                'man:PostCode' => $_POST['PostCode'],
//                'man:Country' => $_POST['Country'],
//                'man:Email' => $_POST['Email'],
//                'man:Fax' => $_POST['Fax'],
//                'man:Phone' => $_POST['Phone'],
//                'man:Mobile' => $_POST['Mobile'],
//                'man:CustomerRef' => $_POST['CustomerRef'],
//                'man:JobDesc' => $_POST['JobDesc'],
//                'man:Comments' => $_POST['Comments'],
//                'man:URL' => $_POST['URL'],
                'man:CCNumber' => $_POST['data']['User']['card_number'],
                'man:CCNameOnCard' => $_POST['data']['User']['card_name'],
                'man:CCExpiryMonth' => $_POST['data']['User']['card_expiration_month'],
                'man:CCExpiryYear' => $_POST['data']['User']['card_expiration_year']
            );
            $soapaction = 'https://www.eway.com.au/gateway/managedpayment/CreateCustomer';
            $result = $client->call('man:CreateCustomer', $requestbody, '', $soapaction);
            var_dump($result);

           /*
            $pass_id = $this->reqeust->data['Payment']['pass_id'];
            $card_name = $this->reqeust->data['User']['card_name'];
            $card_name = $this->reqeust->data['User']['card_number'];
            $exp_month = $this->reqeust->data['User']['card_expiration_month'];
            $exp_year = $this->reqeust->data['User']['card_expiration_year'];
            $ccv = $this->reqeust->data['User']['card_ccv'];
         */

            /*
            if ($this->Payment->save($this->reqeust->data)){
                if ($this->request->is('ajax')) {
                    $this->ajax_response(array('success' => true));
                }
            } else {
                if ($this->request->is('ajax')) {
                    $this->ajax_response(array('error' => 'data could not be saved'));
                }
            }
            */
            $this->ajax_response(array('success' => true));

        }
    }

    function paymentToken() {
       //Zubair: This actioan will be called where user already have a token in user table.
        // so we will need to use this token & get the payment.

        if (!$this->isLoggedIn()) {
            $this->redirect('/users/login');
        }else {
            $options = array(
                'conditions' => array('User.id' => $this->user_id())
            );
            $dbuser = $this->User->find('all', $options);
        }

        $this->ajax_response(array('success' => true,'user_id' => $this->user_id()));
       /*
        $user_token = $dbuser['User']['payment_token'];

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('Payment');

            $amount = "9.95";
            //$pass_id = $this->reqeust->data['Payment']['pass_id'];


            $this->ajax_response(array('success' => true));

        }
        */
    }


    function logout() {
        // delete the user session
        $this->Session->destroy();
        // redirect to posts index page
        $this->Session->setFlash('You have successfully logged out.');
        $this->redirect('/');
    }

    function send_password() {
        $this->autoRender = false;
        if ($this->request->is('post') || $this->request->is('put')) {
            $email = $this->request->data['email'];
            if (empty($email)) {
                $this->ajax_response(array('error' => 'Email is not valid'));
            }
            $user = $this->User->find('first', array('recursive' => -1, 'conditions' => array('email' => $email)));
            if (empty($user)) {
                $this->ajax_response(array('error' => 'The user could not be found. Please, try again.'));
            } else {
                $content = "The password for login is : " . $user['User']['password'];
                $this->Email->to = $user['User']['email'];
                $this->Email->from = 'mrafiq1465@gmail.com';
                $this->Email->subject = 'Login Information';
                $success = $this->Email->send($content, null, null);
                if ($success) $this->ajax_response(array('success' => 'Password sent to the mail address.'));
                else $this->ajax_response(array('error' => 'Email could not be sent.'));
            }
        }
    }

}
