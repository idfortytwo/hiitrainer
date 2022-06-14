<?php

namespace Routing;

interface IRoute {
    function getPath(): string;
    function getMethods(): array;
}
