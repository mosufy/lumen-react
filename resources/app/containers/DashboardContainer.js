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
              visibilityFilter={this.props.visibilityFilter}
              addTodo={this.props.addTodo}
              toggleCompleted={this.props.toggleCompleted}
              setVisibilityFilter={this.props.setVisibilityFilter}/>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    todos: state.todos,
    visibilityFilter: state.visibilityFilter
  }
};

const mapDispatchToProps = (dispatch) => {
  return {
    addTodo: (e) => {
      var todoName = $("#todo_name");

      e.preventDefault();
      dispatch(actionCreators.addTodo(todoName.val()));
      todoName.val('');
    },
    toggleCompleted: (e) => {
      var id = $(e.target).closest("input").attr('id');
      dispatch(actionCreators.toggleCompleted(id));
    },
    setVisibilityFilter: (filter) => {
      dispatch(actionCreators.setVisibilityFilter(filter));
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(DashboardContainer);