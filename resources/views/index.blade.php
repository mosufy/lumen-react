<!DOCTYPE html>
<html>
<head>
  <!-- ReactJS required files -->
  <script src="js/react.min.js"></script>
  <script src="js/react-dom.min.js"></script>
  <script src="js/babel.min.js"></script>
</head>
<body>
<div id="container"></div>
<script type="text/babel">
  var MyName = React.createClass({
    incrementCount: function () {
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

  var FilteredList = React.createClass({
    filterList: function (event) {
      var updatedList = this.state.initialItems;
      updatedList = updatedList.filter(function (item) {
        return item.toLowerCase().search(
            event.target.value.toLowerCase()) !== -1;
      });
      this.setState({items: updatedList});
    },
    getInitialState: function () {
      return {
        initialItems: [
          "Apples",
          "Broccoli",
          "Chicken",
          "Duck",
          "Eggs",
          "Fish",
          "Granola",
          "Hash Browns"
        ],
        items: []
      }
    },
    componentWillMount: function () {
      this.setState({items: this.state.initialItems})
    },
    render: function () {
      return (
        <div className="filter-list">
          <input type="text" placeholder="Search" onChange={this.filterList}/>
          <List items={this.state.items}/>
        </div>
      )
    }
  });

  var List = React.createClass({
    render: function () {
      return (
        <ul>
          {
            this.props.items.map(function (item) {
              return <li key={item}>{item}</li>
            })
          }
        </ul>
      )
    }
  });

  ReactDOM.render(
    <div>
      <MyName name="me"/>
      <FilteredList/>
    </div>,
    document.getElementById('container'));
</script>
</body>
</html>