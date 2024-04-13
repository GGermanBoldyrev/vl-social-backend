<?php

namespace src\enums;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case DELETE;
    case PATCH;
    case OPTIONS;
    case TRACE;
    case CONNECT;
}
