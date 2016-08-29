<?php
  use SyntaxTreeApi\Model\ParseSyntaxCommandFactory;
?>
<!DOCTYPE html>
<html lang="en">

<title>Syntax tree</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">

<body>

<div class="container-fluid">

    <h1>Parser of syntax of russian sentences (API)</h1>

    <form method="post">
        <input name="option" type="hidden" value="JSON_PRETTY_PRINT">

        <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="text">Text</label>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <textarea class="form-control" id="text" name="text" placeholder="Sentence"><?php echo htmlspecialchars($text) ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="format">Result format</label>
              </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="format" name="format">
                        <option>-</option>
                        <option>JSON</option>
                        <option>CoNLL-X</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label for="format">System</label>
              </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="system" name="system">
                        <option <?php echo $system === ParseSyntaxCommandFactory::SYSTEM_TENSOR_FLOW ? 'selected="selected"' : ''; ?>>TensorFlow</option>
                        <option <?php echo $system === ParseSyntaxCommandFactory::SYSTEM_MALT_PARSER ? 'selected="selected"' : ''; ?>>MaltParser</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <hr>

    <p><label>Text:</label> <?php echo htmlspecialchars($text); ?></p>

    <p><label>Processed response:</label></p>

    <div id="tree"></div>

    <p><label>Raw response &mdash; <a href="http://ilk.uvt.nl/conll/#dataformat">CoNLL-X</a> (CSV):</label></p>
    <pre><?php echo $csv ?></pre>

    <p><label>Json:</label></p>
    <pre><?php echo $trees->toJson(JSON_PRETTY_PRINT); ?></pre>
</div>

<script src="vendor/d3/d3.min.js"></script>
<script src="js/syntax-tree.js"></script>
<script>
    var data = <?php echo isset($trees[0]) ? $trees[0]->toJson() : 'null'; ?>;
    buildSyntaxTree(data);
</script>

</body>
</html>
