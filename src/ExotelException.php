<?php


namespace MVKaran\Exotel;


class ExotelException extends \Exception {

}

class RateLimitExceededException extends ExotelException {

}

class InsufficientParametersException extends ExotelException {

}