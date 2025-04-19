<?php


trait FetchesFromPaginator {

    private static function getAllItemsFromPaginator(int $nbrItems, int $pageNum, callable $paginatorClosure): array {
        $paginator = $paginatorClosure($nbrItems, $pageNum);
        // Get all the items of the dataset
        $items = [];
        foreach($paginator->items() as $item) {
            $items[] = $item;
        }
        // The paginator has to be refetched for each page
        while ($paginator->hasMorePages()) {
            $paginator = $paginatorClosure($nbrItems, $paginator->currentPage() + 1);
            foreach($paginator->items() as $item) {
                $items[] = $item;
            }
        }
        return $items;
    }
}