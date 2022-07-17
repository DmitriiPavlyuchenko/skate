<?php

declare(strict_types=1);

namespace App\Trait\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * @codeCoverageIgnore
 */
trait Pagination
{
    private function getPage(Request $request): int
    {
        $page = (int) ($request->get('page', 1));
        if ($page < 1) {
            $page = 1;
        }

        return $page;
    }

    private function getLimit(Request $request): int
    {
        $limit = (int) $request->get('limit');
        if ($limit < 1 || $limit > 20) {
            $limit = 20;
        }

        return $limit;
    }

    private function getOffset(Request $request): int
    {
        $offset = 0;
        $page = $this->getPage($request);
        if ($page !== 1) {
            $offset = ($page - 1) * $this->getLimit($request);
        }

        return $offset;
    }
}
