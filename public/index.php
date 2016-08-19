<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<script src="vendor/d3/d3.min.js"></script>

<link rel="stylesheet" href="css/style.css">

<body>

<form method="post">
  <div class="form-group">
    <label for="text">Text</label>
    <textarea class="form-control" id="text" name="text" placeholder="Sentence"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



<?php

ini_set('display_errors', TRUE);
error_reporting(-1);

require '../vendor/autoload.php';

$text = $_POST['text'] ?? null;

echo '<p><label>Text:</label></p>';
echo "<p>$text</p>";

$command = "/usr/local/tensorflow/models/syntaxnet/syntaxnet/models/parsey_universal/parse.sh /usr/local/tensorflow/Russian-SynTagRus 2>&1";
$path = '/usr/local/tensorflow/models/syntaxnet/';

$descriptors = array(
    0 => array('pipe', 'r'), // stdin
    1 => array('pipe', 'w'), // stdout
    2 => array('pipe', 'w')  // stderr
);

// Here is problem
$process = proc_open($command, $descriptors, $pipes, $path);

echo '<p><label>Command:</label></p>';
echo "<p>$command</p>";

if (is_resource($process))
{

    fwrite($pipes[0], $text);
    fclose($pipes[0]);

    $csv = stream_get_contents($pipes[1]);
    echo '<p><label>csv:</label></p>';
    echo "<p>$csv</p>";

    $return_value = proc_close($process);
    echo '<p><label>Val:</label></p>';
    echo "<p>$return_value</p>";
}


$csv = '1	Начальник	_	NOUN	_	Animacy=Anim|Case=Nom|Gender=Masc|Number=Sing|fPOS=NOUN++	7	nsubj	_	_
2	Службы	_	NOUN	_	Animacy=Inan|Case=Gen|Gender=Fem|Number=Sing|fPOS=NOUN++	1	dobj	_	_
3	безопасности	_	NOUN	_	Animacy=Inan|Case=Gen|Gender=Fem|Number=Sing|fPOS=NOUN++	2	dobj	_	_
4	Украины	_	NOUN	_	Animacy=Inan|Case=Gen|Gender=Fem|Number=Sing|fPOS=NOUN++	2	nmod	_	_
5	Владимир	_	NOUN	_	Animacy=Anim|Case=Nom|Gender=Masc|Number=Sing|fPOS=NOUN++	1	appos	_	_
6	Путин	_	NOUN	_	Animacy=Anim|Case=Nom|Gender=Masc|Number=Sing|fPOS=NOUN++	5	name	_	_
7	подтвердил,	_	VERB	_	Degree=Pos|fPOS=ADV++	0	ROOT	_	_
8	что	_	PRON	_	fPOS=SCONJ++	20	mark	_	_
9	двух	_	NUM	_	Case=Gen|fPOS=NUM++	10	nummod	_	_
10	россиян,	_	NOUN	_	Animacy=Inan|Case=Gen|Gender=Fem|Number=Sing|fPOS=NOUN++	20	nsubj	_	_
11	фигурирующих	_	VERB	_	Aspect=Imp|Case=Gen|Number=Plur|Tense=Pres|VerbForm=Part|Voice=Act|fPOS=VERB++	10	nmod	_	_
12	в	_	ADP	_	fPOS=ADP++	13	case	_	_
13	деле	_	NOUN	_	Animacy=Inan|Case=Loc|Gender=Neut|Number=Sing|fPOS=NOUN++	11	nmod	_	_
14	о	_	ADP	_	fPOS=ADP++	15	case	_	_
15	событиях	_	NOUN	_	Animacy=Inan|Case=Loc|Gender=Neut|Number=Plur|fPOS=NOUN++	13	nmod	_	_
16	в	_	ADP	_	fPOS=ADP++	17	case	_	_
17	Киеве	_	NOUN	_	Animacy=Inan|Case=Loc|Gender=Masc|Number=Sing|fPOS=NOUN++	15	nmod	_	_
18	2	_	NUM	_	fPOS=NUM++	19	nummod	_	_
19	мая,	_	NOUN	_	Animacy=Inan|Case=Gen|Gender=Masc|Number=Sing|fPOS=NOUN++	17	nmod	_	_
20	могут	_	VERB	_	Aspect=Imp|Mood=Ind|Number=Plur|Person=3|Tense=Pres|VerbForm=Fin|Voice=Act|fPOS=VERB++	7	advcl	_	_
21	обменять	_	VERB	_	Aspect=Perf|VerbForm=Inf|fPOS=VERB++	20	xcomp	_	_
22	на	_	ADP	_	fPOS=ADP++	24	case	_	_
23	двух	_	NUM	_	Animacy=Anim|Case=Acc|Gender=Masc|fPOS=NUM++	24	nummod	_	_
24	граждан	_	NOUN	_	Animacy=Anim|Case=Gen|Gender=Masc|Number=Plur|fPOS=NOUN++	21	iobj	_	_
25	Украины,	_	NOUN	_	fPOS=CONJ++	21	dobj	_	_
26	которые	_	ADJ	_	Case=Nom|Degree=Pos|Number=Plur|fPOS=ADJ++	28	nsubj	_	_
27	сейчас	_	ADV	_	Degree=Pos|fPOS=ADV++	28	advmod	_	_
28	находятся	_	VERB	_	Aspect=Imp|Mood=Ind|Number=Plur|Person=3|Tense=Pres|VerbForm=Fin|Voice=Act|fPOS=VERB++	25	acl:relcl	_	_
29	в	_	ADP	_	fPOS=ADP++	30	case	_	_
30	России.	_	NOUN	_	Animacy=Inan|Case=Loc|Gender=Fem|Number=Sing|fPOS=NOUN++	28	nmod	_	_';
$syntaxTree = new \SyntaxTree\SyntaxTree();
$tree = $syntaxTree->build($csv);

?>


<script>

var margin = {top: 20, right: 120, bottom: 20, left: 120},
    width = window.innerWidth - margin.right - margin.left,
    height = 800 - margin.top - margin.bottom
    ;

var i = 0,
    duration = 750,
    root;

var tree = d3.layout.tree()
    .size([height, width]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.right + margin.left)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var data = JSON.parse('<?php echo $tree->toJson(); ?>');

console.log(data);
  root = data[0];
  root.x0 = height / 2;
  root.y0 = 0;

  function collapse(d) {
    if (d.children) {
      d._children = d.children;
      d._children.forEach(collapse);
      d.children = null;
    }
  }

  update(root);

d3.select(self.frameElement).style("height", "800px");

function update(source) {

  // Compute the new tree layout.
  var nodes = tree.nodes(root).reverse(),
      links = tree.links(nodes);

  // Normalize for fixed-depth.
  nodes.forEach(function(d) { d.y = d.depth * 180; });

  // Update the nodes…
  var node = svg.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });

  // Enter any new nodes at the parent's previous position.
  var nodeEnter = node.enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .on("click", click);

  nodeEnter.append("circle")
      .attr("r", 1e-6)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

  nodeEnter.append("text")
      .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
      .attr("dy", ".35em")
      .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
      .text(function(d) { return d.text; })
      .style("fill-opacity", 1e-6);

  // Transition nodes to their new position.
  var nodeUpdate = node.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

  nodeUpdate.select("circle")
      .attr("r", 4.5)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

  nodeUpdate.select("text")
      .style("fill-opacity", 1);

  // Transition exiting nodes to the parent's new position.
  var nodeExit = node.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
      .remove();

  nodeExit.select("circle")
      .attr("r", 1e-6);

  nodeExit.select("text")
      .style("fill-opacity", 1e-6);

  // Update the links…
  var link = svg.selectAll("path.link")
      .data(links, function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      });

  // Transition links to their new position.
  link.transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition exiting nodes to the parent's new position.
  link.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();

  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}

// Toggle children on click.
function click(d) {
  if (d.children) {
    d._children = d.children;
    d.children = null;
  } else {
    d.children = d._children;
    d._children = null;
  }
  update(d);
}

</script>


    </body>
</html>
