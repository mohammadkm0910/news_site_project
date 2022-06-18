<?php /** @noinspection ALL */

namespace Core\Traits;

use Closure;

trait View
{
    private $vars;
    private $extensions = [];
    private $echoFormat = '$this->e(%s)';

    protected function view($dir, $vars = null)
    {
        $this->vars = $vars ?? [];
        $this->prepareView($dir);
    }
    private function prepare($dir) {
        $dir = str_replace('.', DS, $dir);
        return glob((BASE_PATH.DS.'app'.DS.'view'.DS.$dir).'.*')[0];
    }
    private function prepareView($dir)
    {
        $mainDir = $this->prepare($dir);
        if (file_exists($mainDir)) {
            if (!empty($this->vars)) extract($this->vars);
            $content = htmlentities(file_get_contents($mainDir), ENT_COMPAT);
            $this->extend(function ($value) {
                return preg_replace("/@set\(['\"](.*?)['\"],(.*)\)/", '<?php $$1 =$2; ?>', $value);
            });
            $compilers = ['Statements', 'Comments', 'Echos', 'Extensions'];
            foreach ($compilers as $compiler) {
                $content = $this->{'compile'.$compiler}($content);
            }
            $content = $this->replacePhpBlocks($content);
            eval('?>'.html_entity_decode($content));
        } else {
            echo "this view [$dir] not exist";
        }
    }
    private function extend(Closure $compiler)
    {
        $this->extensions[] = $compiler;
    }
    private function compileStatements($statement)
    {
        return preg_replace_callback($this->segments(), function ($match) {
            // default commands
            if (method_exists($this, $method = 'compile'.ucfirst($match[1]))) {
                $match[0] = $this->{$method}($match[3] ?? '');
            }
            return isset($match[3]) ? $match[0] : $match[0].$match[2];
        }, $statement);
    }
    private function segments(): string
    {
        return '/\B@(@?\w+(?:->\w+)?)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x';
    }
    private function compileComments($comment)
    {
        return preg_replace('/\{\{--((.|\s)*?)--}}/', '<?php /*$1*/ ?>', $comment);
    }
    private function compileEchos($string)
    {
        // compile escaped echoes
        $string = preg_replace_callback('/\{\{\{\s*(.+?)\s*}}}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[2]) ? '' : $matches[2].$matches[2];
            return '<?php echo $this->e('.$this->compileEchoDefaults($matches[1]).') ?>'.$whitespace;
        }, $string);
        // compile unescaped echoes
        $string = preg_replace_callback('/\{!!\s*(.+?)\s*!!}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[2]) ? '' : $matches[2].$matches[2];
            return '<?php echo '.$this->compileEchoDefaults($matches[1]).' ?>'.$whitespace;
        }, $string);
        // compile regular echoes
        return preg_replace_callback('/(@)?\{\{\s*(.+?)\s*}}(\r?\n)?/s', function ($matches) {
            $whitespace = empty($matches[3]) ? '' : $matches[3].$matches[3];
            return $matches[1]
                ? substr($matches[0], 1)
                : '<?php echo '
                .sprintf($this->echoFormat, $this->compileEchoDefaults($matches[2]))
                .' ?>'.$whitespace;
        }, $string);
    }
    private function compileEchoDefaults($string)
    {
        return preg_replace('/^(?=\$)(.+?)\s+or\s+(.+?)$/s', 'isset($1) ? $1 : $2', $string);
    }
    private function compileExtensions($string)
    {
        foreach ($this->extensions as $compiler) {
            $string = $compiler($string, $this);
        }
        return $string;
    }
    private function compileInclude($view): string
    {
        if (isset($view[0]) && '(' === $view[0]) {
            $view = substr($view, 1, -1);
        }
        return "<?php include \$this->prepare({$view}) ?>";
    }
    private function e($string, $charset = null): string
    {
        return htmlspecialchars($string, ENT_QUOTES, is_null($charset) ? 'UTF-8' : $charset);
    }
    private function compilePhp($value): string
    {
        return $value ? "<?php {$value}; ?>" : "@php{$value}";
    }
    private function replacePhpBlocks($string)
    {
        return preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function ($matches) {
            return "<?php{$matches[1]}?>";
        }, $string);
    }
    protected function asset($src)
    {
        $src = str_replace("asset", "", $src);
        $src = trim($src, "/");
        echo BASE_ASSET."/$src";
    }
    protected function url($address)
    {
        $address = trim($address, "/");
        echo BASE_URL."/$address";
    }
    protected function error404()
    {
        http_response_code(404);
        require_once fix_path(BASE_PATH."/app/view/error/error404.php");
        exit();
    }
}