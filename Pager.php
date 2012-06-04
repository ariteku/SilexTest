<?php

class Pager
{
	/*
	* Copyright (c) 2009 QUALL  quall.net
	* Licensed under the MIT License:
	* http://www.opensource.org/licenses/mit-license.php
	*
	* @params
	* 　$total_count(int) : 全件数
	* 　$curpage(int) : 現在のページ
	* 　$perpage(int) : 1ページの最大表示件数
	* 　$range(int) :  ページャーの表示個数
	*
	* @return(array)
	* 　$total_pages(int) : 総ページ数
	* 　$curpage(int) : 今のページ
	* 　$start_page(int)   ：表示開始ページ
	* 　$end_page(int)	 ：表示最後ページ
	* 　$start_cnt(int)	：表示開始件数
	* 　$end_cnt(int)	 ：表示最後件数
	* 　$prev(int)	: 前のページ
	* 　$next(int)	: 次のページ
	* 　$offset(int)  : select開始ポイント
	* 　$limit(int)   : select取得件数
	*
	*/
	function getPager($total_count = NULL, $curpage = 1, $perpage = 15, $range = 5) {
		$total_count = ceil($total_count);
		//total_pages
		$total_pages = ceil($total_count / $perpage);

		//range
		$range = ($total_pages < $range)? $total_pages : $range;

		//start_page
		if ($curpage >= ceil($range / 2)) {
			$start_page = $curpage - floor($range / 2);
		}
		$start_page = ($start_page < 1)? 1 : $start_page;   // １未満は１にする

		//end_page
		$end_page   = $start_page + $range - 1;
		if ($curpage > $total_pages - ceil($range / 2)) {	//最後らへんのページとか
			$end_page   = $total_pages;
			$start_page = $end_page - $range + 1;
		}

		//start_cnt
		$start_cnt = ceil($curpage - 1) * $perpage + 1;

		//end_cnt
		$end_cnt = ceil($curpage) * $perpage <  $total_count ? ceil($curpage) * $perpage : $total_count;

		//prev
		if ($curpage > $start_page) {
			$prev = $curpage - 1;
		} else {
			$prev = NULL;
		}

		//next
		if ($curpage < $end_page) {
			$next = $curpage + 1;
		} else {
			$next = NULL;
		}

		//offset
		$offset = ceil($curpage - 1) * $perpage;

		//limit
		$limit = ($total_count < $perpage)? $total_count : $perpage;

		return array(
					'total_count' => $total_count,
					'total_pages' => $total_pages,
					'curpage'     => $curpage,
					'range'       => $range,
					'start_page'  => $start_page,
					'end_page'    => $end_page,
					'start_cnt'   => $start_cnt,
					'end_cnt'     => $end_cnt,
					'prev'        => $prev,
					'next'        => $next,
					'offset'      => $offset,
					'limit'       => $limit
					);
	}
}
