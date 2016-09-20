<!DOCTYPE html>
<html>
<head>
  <!-- ReactJS required files -->
  <script src="js/head.js"></script>
</head>
<body>
<div id="container"></div>
<script type="text/babel">
  var Counter = React.createClass({
    incrementCount: function(){
      this.setState({
        count: this.state.count + 1
      });
    },
    getInitialState: function () {
      return {
        count: 5
      }
    },
    render: function () {
      return (
        <div>
          <h1>Hello, {this.props.name}!</h1>
          <p>Count: {this.state.count}</p>
          <button type="button" onClick={this.incrementCount}>Increment</button>
        </div>
      );
    }
  });

  ReactDOM.render(
    <Counter name="me"/>, document.getElementById('container')
  );
</script>
</body>
</html>