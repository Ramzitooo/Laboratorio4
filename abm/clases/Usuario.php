<?php
require_once"accesoDatos.php";
class Usuario
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
 	public $mail;
  	public $pass;
  	public $nick;


//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function GetMail()
	{
		return $this->mail;
	}
	public function GetPass()
	{
		return $this->pass;
	}
	public function GetNick()
	{
		return $this->nick;
	}

	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function SetMail($valor)
	{
		$this->mail = $valor;
	}
	public function SetPass($valor)
	{
		$this->pass = $valor;
	}
	public function SetNick($valor)
	{
		$this->nick = $valor;
	}

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function Buscar($idParametro) 
	{	


		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where id =:id");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
					
	}

	public static function Chequear($mail, $pass) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where mail =:mail and pass =:pass");
		$consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
		$consulta->bindValue(':pass', $pass, PDO::PARAM_STR);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;	
					
	}
	
	public static function TraerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario");
		$consulta->execute();			
		$arrUsuarios= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrUsuarios;
	}
	
	public static function Eliminar($id)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from usuario WHERE id=:id");	
		$consulta->bindValue(':id',$id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function Modificar($usuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set nick=:nick, mail=:mail, pass=:pass
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
			$consulta->bindValue(':id',$usuario->id, PDO::PARAM_INT);
			$consulta->bindValue(':nick',$usuario->nick, PDO::PARAM_STR);
            $consulta->bindValue(':pass',$usuario->pass, PDO::PARAM_STR);
            $consulta->bindValue(':mail',$usuario->mail, PDO::PARAM_STR);
            
			return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function Agregar($usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nick,mail,pass) values(:nick,:mail,:pass)");
		$consulta->bindValue(':nick',$usuario->nick, PDO::PARAM_STR);
		$consulta->bindValue(':mail', $usuario->mail, PDO::PARAM_STR);
		$consulta->bindValue(':pass', $usuario->pass, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	

}