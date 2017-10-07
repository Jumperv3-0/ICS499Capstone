<?php
class User {
    public function User($username, $email, $password, $city, $street, $zip, $phonenumber, $fname, $lname) {
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->city = $city;
		$this->street = $street;
		$this->zip = $zip;
		$this->phonenumber = $phonenumber;
		$this->fname = $fname;
		$this->lname = $lname;
    }
}

class Item {
	public function Item ($image, $description, $price, $issold, $keyword) {
		$this->image = $image;
		$this->description = $description;
		$this->price = $price;
		$this->issold = $issold;
		$this->keyword = $keyword;
	}
}
//pull "location" from google maps. Otherwise replace with: City, Street, Zip.
class GarageSale {
	public function GarageSale ($image, $description, $date, $location, $items, $user)
		$this->image = $image;
		$this->description = $description;
		$this->date = $date;
		$this->location = $location;
		$this->items = $items;
		$this->user = $user;
}
?>
