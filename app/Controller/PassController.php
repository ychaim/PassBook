<?php
App::uses('AppController', 'Controller');
/**
 * Pass Controller
 *
 * @property Pass $Pass
 */
class PassController extends AppController
{


    public function index()
    {

    }

    public function create($action = 'event')
    {
        $pass_type = $this->Pass->PassType->find('first',array(
            'recursive' => -1,
            'conditions' => array(
                'name' => $action
            ),
        ));
        $pass_type_id = $pass_type['PassType']['id'];

        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->Pass->create();
            $this->request->data['Pass']['pass_type_id'] = $pass_type_id;
            if ($this->Pass->save($this->request->data)) {
                $this->ajax_response(array('success' => array('id' => $this->Pass->id)));
            } else {
                $this->ajax_response(array('error' => __('The user could not be saved. Please, try again.')));
            }
        }
    }

    public function edit($id, $step = 'step1')
    {
        if (empty($id)) {
            throw new NotFoundException(__('Invalid id'));
        }
        $this->Pass->id = $id;
        if (!$this->Pass->exists()) {
            throw new NotFoundException(__('Invalid pass'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->autoRender = false;
            $this->Pass->read();

            if (isset($this->request->query['remove'])) {
                $remove_field = $this->request->query['remove'];
                preg_match('/data\[(.+)\]/',$remove_field,$remove_field_array);
                $remove_field = $remove_field_array[1];
                if (!empty($this->Pass->data['Pass'][$remove_field])) {
                    unlink(WWW_ROOT . $this->Pass->data['Pass'][$remove_field]);
                    $this->Pass->data['Pass'][$remove_field] = '';
                    $this->Pass->save($this->Pass->data);
                    $this->ajax_response(array('success' => true));
                }
            } else {
                foreach ($this->request->data as $k=>$val) {
                    if ((isset($val['error']) && $val['error'] == 0) ||
                        (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none' && is_uploaded_file($val['tmp_name']))
                    ) {
                        $uploaded_field = $k;
                    }
                }
                if (isset($uploaded_field)) {
                    usleep(300000);
                    $destination_dir = WWW_ROOT . "data" . DS . $id . DS;
                    if (!is_dir($destination_dir)) {
                        mkdir($destination_dir, 0777, true);
                    }

                    if (strstr($uploaded_field, 'Retina')) $file_name = str_replace('ImageRetina','@2x', $uploaded_field);
                    else $file_name = str_replace('Image','',$uploaded_field);

                    $destination_path = $destination_dir . "$file_name.png";

                    move_uploaded_file($this->request->data[$uploaded_field]['tmp_name'], $destination_path);
                    $this->Pass->data['Pass'][$uploaded_field] = str_replace(WWW_ROOT, '', $destination_path);
                    $this->Pass->save($this->Pass->data);
                } else {
                    $this->encodeDynamicFields($this->request->data);
                    $this->Pass->save($this->request->data);
                }
            }

            if (isset($destination_path)) $this->ajax_response(array('success' => '/' . str_replace(WWW_ROOT, '', $destination_path)));
            else $this->ajax_response(array('success' => $id));
        }

        $this->request->data = $this->Pass->read(null, $id);
        $this->decodeDynamicFields($this->request->data);

        $step = substr($step, 4);

        $barcodeFormats = $this->Pass->BarcodeFormat->find('list');

        $this->set(compact('step', 'barcodeFormats'));
    }

    public function generate_pass($id)
    {
        $this->autoRender = false;

        if ($this->request->is('post') || $this->request->is('put')) {
            $to = $this->request->data['email'];
            if (empty($to)) {
                die(json_encode(array('error' => 'email not given')));
            }
            $pass = $this->Pass->generate_pass($id);
            if (!isset($pass['error'])) {
                App::uses('CakeEmail', 'Network/Email');
                $email = new CakeEmail();
                $email->from(array(SITE_EMAIL => SITE_NAME));
                $email->to($to);
                $email->subject('Pass file');
                $email->attachments($pass['path']);
                $email->send('My message');
                $this->ajax_response(array('success' => true));
            } else {
                $this->ajax_response(array('error' => $pass['error']));
            }
        } else {
            $this->ajax_response(array('error' => 'Invalid method'));
        }

    }

    public function encodeDynamicFields(&$data)
    {
        if (isset($data['Pass']['primaryFields'])) $data['Pass']['primaryFields'] = json_encode(array_merge(array_filter(
            $data['Pass']['primaryFields'],
            array($this, 'check_all_keys_values'))));

        if (isset($data['Pass']['secondaryFields'])) $data['Pass']['secondaryFields'] = json_encode(array_merge(array_filter(
            $data['Pass']['secondaryFields'],
            array($this, 'check_all_keys_values'))));

        if (isset($data['Pass']['auxiliaryFields']))$data['Pass']['auxiliaryFields'] = json_encode(array_merge(array_filter(
            $data['Pass']['auxiliaryFields'],
            array($this, 'check_all_keys_values'))));

        if (isset($data['Pass']['backFields'])) $data['Pass']['backFields'] = json_encode(array_merge(array_filter(
            $data['Pass']['backFields'],
            array($this, 'check_all_keys_values'))));

        if (isset($data['Pass']['locations'])) $data['Pass']['locations'] = json_encode(array_merge(array_filter(
            $data['Pass']['locations'],
            array($this, 'check_all_keys_values'))));
    }
    public function decodeDynamicFields(&$data)
    {
        if (!empty($data['Pass']['primaryFields'])) {
            $data['Pass']['primaryFields'] = json_decode($data['Pass']['primaryFields'],1);
        }
        if (!empty($data['Pass']['secondaryFields'])) {
            $data['Pass']['secondaryFields'] = json_decode($data['Pass']['secondaryFields'],1);
        }
        if (!empty($data['Pass']['auxiliaryFields'])) {
            $data['Pass']['auxiliaryFields'] = json_decode($data['Pass']['auxiliaryFields'],1);
        }
        if (!empty($data['Pass']['backFields'])) {
            $data['Pass']['backFields'] = json_decode($data['Pass']['backFields'],1);
        }
        if (!empty($data['Pass']['locations'])) {
            $data['Pass']['locations'] = json_decode($data['Pass']['locations'],1);
        }

    }

    public function check_all_keys_values($item)
    {
        foreach ($item as $v) {
            if ($v == '' || is_null($v)) {
                return false;
            }
        }
        return true;
    }
}
