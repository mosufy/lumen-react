/**
 * DashboardContainer
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodo from './../components/MyTodo';
import {connect} from 'react-redux';
import * as actionCreators from './../actions';

class DashboardContainer extends React.Component {
  render() {
    return (
      <MyTodo items={this.props.todos}
              addTodo={this.props.addTodo}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    todos: state.todos
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    addTodo: (e) => {
      var todoName = $("#todo_name");

      e.preventDefault();
      dispatch(actionCreators.addTodo(todoName.val()));
      todoName.val('');
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);