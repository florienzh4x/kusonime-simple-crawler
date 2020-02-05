<?php

class Kusonime{
	
	public static $link;
	public static $resolusi;

	public static function getPage(){
		$sc = file_get_contents(self::$link);
		preg_match_all("/<div class=\"smokeurl\">(.*?)<\/div>/i", $sc, $page);
		preg_match_all("/\"headline\": \"(.*?)\"/i", $sc, $judul);
		return (object) [
			'page' => $page[1],
			'judul' => $judul[1][0],
		];
	}

	public static function getKey(){
		foreach (self::getPage()->page as $value) {
			preg_match_all("/<strong>(.*?)<\/strong>/i", $value, $res);
			$resolusi[] = $res[1];
		}
		foreach ($resolusi as $no) {
			$reso[] = $no[0];
		}
		return $reso;
	}

	public static function getLink(){
		foreach (self::getPage()->page as $value) {
			preg_match_all("/<strong>(.*?)<\/strong>/i", $value, $res);
			$reso = self::getKey();
			if ($res[1][0] == $reso[self::$resolusi]) {
				echo "Link Download Resolusi ".$res[1][0].":\n";
				preg_match_all("/<a href=\"(.*?)\"/i", $value, $link);
				foreach ($link[1] as $downLink) {
					$downLink = preg_replace('/amp;/', '', $downLink);
					$download[] = $downLink;
				}
			}
		}
		return $download;
	}
	public static function kuso(){
		self::$link = readline("Masukan link anime: ");
		echo "\n";
		echo "JUDUL ANIME: ".self::getPage()->judul."\n";
		echo "PILIHAN RESOLUSI: ";
		print_r(self::getKey());
		self::$resolusi = readline("Pilih Resolusi Nomor : ");
		print_r(self::getLink());
	}
}
Kusonime::kuso();
?>
