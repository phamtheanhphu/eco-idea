<?php
/**
 * Created by PhpStorm.
 * User: phu.pham
 * Date: 8/3/2017
 * Time: 4:28 PM
 */

namespace API\Entity;

use Zend\Http\Response;

class HttpResponse {

    protected $result;
    protected $data;

    public function __construct($result = null,
                                $data = null) {
        $this->result = $result;
        $this->data = $data;
    }

    //generate the json response
    public function generate_json_response() {

        $httpResponse = new Response();
        $httpResponse->setStatusCode(Response::STATUS_CODE_200);
        $httpResponse->getHeaders()
            ->addHeaderLine('Content-Type', 'application/json');

        $json_response_array = [
            'result' => $this->result
        ];

        //mapping data
        if ($this->data != null) {
            $json_response_array['data'] = $this->data;
        }

        $httpResponse->setContent(
            json_encode(
                $json_response_array
            )
        );

        return $httpResponse;
    }

    /**
     * @return null
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @param null $result
     */
    public function setResult($result) {
        $this->result = $result;
    }

    /**
     * @return null
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData($data) {
        $this->data = $data;
    }


}

?>