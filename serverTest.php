<?php
/**
 * Created by IntelliJ IDEA.
 * User: wangchao
 * Date: 9/18/15
 * Time: 10:27 AM
 */


namespace WatcherHangzhou;

WAutoloader(['WatcherHangzhou'=>__DIR__]);


class echoServer extends WebSocketServer {
    //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

    protected function process ($user, $message) {

        echo "receive from client, message:".$message.PHP_EOL;
        $this->send($user,'Response from Server 233'.$message);

    }

    protected function connected ($user) {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.
    }

    protected function closed ($user) {
        // Do nothing: This is where cleanup would go, in case the user had any sort of
        // open files or other objects associated with them.  This runs after the socket
        // has been closed, so there is no need to clean up the socket itself here.
    }
}

$echo = new echoServer("0.0.0.0","9000");

try {
    $echo->run();
}
catch (\Exception $e) {
    $echo->stdout($e->getMessage());
}







function WAutoloader($directories, $fileFormat = null, $namespaceAliases = null, $classAliases = null) {
    $fileFormat = $fileFormat ?: '%s.php';
    $namespaceAliases = $namespaceAliases ?: array();
    $classAliases = $classAliases ?: array();
    spl_autoload_register(function($class) use ($fileFormat, $directories, $namespaceAliases, $classAliases) {
        $realClass = (isset($classAliases[$class]) === false ? $class : $classAliases[$class]);
        foreach ($namespaceAliases as $alias => $namespace)
        {
            $aliasLength = strlen($alias);
            if ($realClass !== $alias && strncmp($alias, $realClass, $aliasLength) === 0)
            {
                $realClass = $namespace . substr($class, $aliasLength);
                break;
            }
        }
        if ($realClass === $class || class_exists($realClass, false) === false) foreach ($directories as $namespace => $directory)
        {
            $namespaceLength = strlen($namespace);
            if ($realClass !== $namespace && strncmp($namespace, $realClass, $namespaceLength) === 0)
            {
                $path = $directory . sprintf($fileFormat, str_replace('\\', DIRECTORY_SEPARATOR, substr($realClass, $namespaceLength)));
                if (is_file($path) === true)
                {
                    require $path;
                }
                break;
            }
        }
        if ($realClass !== $class && class_exists($realClass, false) === true)
        {
            class_alias($realClass, $class);
        }
    }
    );
};