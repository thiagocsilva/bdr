<?php 
interface ICrud
{
	public function all();
	public function find($id);
	public function count();
	public function delete($id);	
	public function deletes($ids = array());
}